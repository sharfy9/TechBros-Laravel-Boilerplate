<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Socialite;
use App\SocialIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    private $redirectTo = "/dashboard";
    public function redirect($service) {
        return Socialite::driver ( $service )->redirect ();
    }

    public function callback($service) {

        try {
            $user = Socialite::with ( $service )->user ();
        } catch (Exception $e) {
            return redirect('/login')->withErrors('An Error Occured. Please Try Again.');
        }

        if(Auth::check())
        {
            if(!Auth::user()->identities()->whereProviderName($service)->first())
            {
                if(!SocialIdentity::whereProviderName($service)
                ->whereProviderId($user->getId())
                ->first()){
                    Auth::user()->identities()->create([
                        'provider_id'   => $user->getId(),
                        'email'   => $user->getEmail(),
                        'provider_name' => $service,
                    ]);
                }
                else
                    return redirect("/profile")->withErrors("This account is already connected with another user.");
            }
            return redirect("/profile")->with(["successMsg" => "$service account linked successfully."]);
        }
        else
        {
            $authUser = $this->findOrCreateUser($user, $service);
            Auth::login($authUser, true);
            return redirect($this->redirectTo);

        }
    }

    public function findOrCreateUser($providerUser, $provider)
    {
        $account = SocialIdentity::whereProviderName($provider)
                   ->whereProviderId($providerUser->getId())
                   ->first();

        if ($account) {
            return $account->user;
        } else {
            $user = User::whereEmail($providerUser->getEmail())->first();

            if (! $user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            }

            $user->identities()->create([
                'provider_id'   => $providerUser->getId(),
                'email'   => $providerUser->getEmail(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }

    public function show() {
        if(!Auth::user()->phone && !Auth::user()->password)
           return view('auth.socialite');
        else
            abort(403);
    }

    public function complete(Request $request) {
        if(Auth::user()->phone || Auth::user()->password)
            abort(403);

        $request->validate([
            'phone' => 'required|numeric|digits:11|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        auth()->user()->update([
            'password' => Hash::make($request->get('password')),
            'phone' => $request->get('phone'),
        ]);
        return redirect('profile')->with(['successMsg' => 'Registration Complete.']);
    }

    public function disconnect($service) {
        $account = Auth::user()->identities()->whereProviderName($service)->first();
        if ($account) {
            $account->delete();
            return redirect()->back()->with(['successMsg' => "$service account disconnected."]);
        }
        else
        return redirect()->back()->withErrors('Could not find social account.');
    }


}
