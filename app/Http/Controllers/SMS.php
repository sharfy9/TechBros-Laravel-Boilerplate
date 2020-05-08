<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Instasent\SMSCounter\SMSCounter;

class SMS extends Controller
{
    protected static $url = "/api/sms/v1/";

    public static function sendDynamic($recipient, $body, $sender = null, $phone = "phone")
    {
        $output = [];
        if(!is_array($recipient))
            return json_encode(["error" => "First parameter should be an associative array containing necessary placeholder data and phone numbers"]);
        foreach($recipient as $index => $item)
        {
            if((is_array($item) && isset($item[$phone])))
                $phone = $item[$phone];
            elseif(is_object($item) && isset($item->$phone))
                $phone = $item->$phone;

            if(isset($phone))
            {
                $msg = $body;
                foreach($item as $key => $value){
                    $msg = str_replace('{'.$key.'}', $value, $msg);
                }
                $output[] = self::send([$phone], $msg);
            }
            else
                $output[] = "Could not find number for #{$index}";
        }
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

        $result = self::makeRequest($url, $payload);
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
    //
}
