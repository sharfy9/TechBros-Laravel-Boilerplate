<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Contracts\Activity;

class tfaController extends Controller
{

    public function setup(Request $request)
    {

        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        $secret = $google2fa->generateSecretKey();
        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            Auth::user()->email,
            $secret
        );

        $encodedTo = rawurlencode(Auth::user()->email);
        $encodedSubject = rawurlencode("Two Factor Authentication Key on ". config('app.name'));
        $encodedBody = rawurlencode("Please use the following key in Google Authenticator app to complete your 2FA setup on ".config('app.name').". The key is: \n\n{$secret}\n\n");
        $uri = "mailto:$encodedTo?subject=$encodedSubject&body=$encodedBody";
        // $link = htmlspecialchars($uri);
        // dd(rawurlencode("&"));
        // Pass the QR barcode image to our view
        return view('twoFactorAuth.setup', ['qr' => $QR_Image, 'secret' => $secret, 'link' => $uri]);
    }

    public function save(Request $request)
    {
        Auth::user()->google2fa_secret = $request->secret;
        Auth::user()->disableLogging();
        Auth::user()->save();
        activity()
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->log('2FA Enabled');

        return redirect('/profile')->with(['successMsg' => __('2FA setup successful.')]);
    }

    public function disable(Request $request)
    {
        Auth::user()->google2fa_secret = null;
        Auth::user()->disableLogging();
        Auth::user()->save();
        activity()
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->log('2FA Disabled');

        return redirect('/profile')->with(['warningMsg' => __('2FA Disabled.')]);
    }

    public function adminDisable(Request $request, $id)
    {
        if(!Auth::user()->hasRole("Super Admin") && !Auth::user()->hasRole("Owner"))
            abort(403);

        $user = User::find($id);
        if($user->hasRole("Super Admin"))
            return redirect()->back()->withErrors('Insufficient Permissions!');
        elseif(!$user)
            return redirect()->back()->withErrors('Specified User Not Found!');

        $user->google2fa_secret = null;
        $user->disableLogging();
        $user->save();
        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->log('2FA Disabled for '.$user->name);

        return redirect()->back()->with(['warningMsg' => __('2FA Disabled.')]);;
    }

}
