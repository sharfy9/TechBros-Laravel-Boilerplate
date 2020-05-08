<?php

namespace App;

use Auth;
use Instasent\SMSCounter\SMSCounter;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 'sms';

    protected static $url = "/api/sms/v1/";
    protected $fillable = ['user_id', 'remote_id', 'number', 'msg', 'count'];
    public static function sendDynamic($recipient, $body, $sender = null, $phone = "phone")
    {
        $output = [];
        if(!is_array($recipient) && !is_object($recipient))
            return json_encode(["error" => "First parameter should be an associative array containing necessary placeholder data and phone numbers"]);

        foreach($recipient as $index => $item)
        {
            $number = null;
            if((is_array($item) && isset($item[$phone])))
                $number = $item[$phone];
            elseif(is_object($item) && isset($item->$phone))
                $number = $item->$phone;
            if(isset($number) && $number)
            {
                $msg = $body;
                foreach($item as $key => $value){
                    $msg = str_replace('{'.$key.'}', $value, $msg);
                }

                $output[] = self::send([$number], $msg);
            }
            else
                $output[] = "Could not find number for #{$index}";
        }
        dd($output);
        return $output;
    }
    public static function send($recipient, $body, $sender = null)
    {
        // return $body;

        if(!is_array($recipient))
            return json_encode(["error" => "First parameter should be array of recipient phone numbers"]);

        $count = self::getCount($body, $recipient);
        // dd($count);

        // $rate = 1.5;
        // $balance = 5;
        // if($count * $rate > $balance)
        //     return json_encode(["error" => "Insufficient Account Balance"]);

        $url = config("techbros.sms.domain") . self::$url . 'send';
        $payload = [
            "userid" => config("techbros.sms.userid"),
            "password" => config("techbros.sms.password"),
            "recipient" => implode(",", $recipient),
            "body" => $body,
            "sender" => $sender ? $sender : config("techbros.sms.sender")
        ];
        $result = null;
        $result = (self::makeRequest($url, $payload));
        $obj = json_decode($result);

        if(isset($obj->code) && $obj->code == 200)
        {
            $remote_id = $obj->message_id;
            foreach($recipient as $number){
                self::create([
                    'user_id' => Auth::check() ? Auth::user()->id : 1,
                    'remote_id' => $remote_id++,
                    'number' => $number,
                    'msg' => $body,
                    'count' => $count,
                ]);
            }
        }
        return $result;
    }

    public static function getCount($body, $recipient)
    {
        $x = new SMSCounter();
        return count($recipient) * $x->count($body)->messages;
    }

    public static function makeRequest($url, $payload)
    {
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
