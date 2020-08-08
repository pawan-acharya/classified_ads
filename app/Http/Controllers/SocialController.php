<?php
 
namespace App\Http\Controllers;
 
use Socialite;
use Lang;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider)
    {
        try {
            $getInfo = Socialite::driver($provider)->user();

            $user = User::where('provider_id', $getInfo->id)->first(); 
            if (!$user) {
                $checkUser = User::where('email', $getInfo->email)->first();
                if($checkUser) {
                   throw new \Exception( Lang::get('auth.user_exists'));
                }
    
                $name = explode(' ', $getInfo->name);
                $user = User::create([
                    'first_name'     => $name[0],
                    'name'     => $name[1],
                    'email'    => $getInfo->email,
                    'provider' => $provider,
                    'provider_id' => $getInfo->id
                ]);
                auth()->login($user);
                return redirect()->route('home.edit')->with('status', Lang::get('auth.complete_profile_first'));
            }
            auth()->login($user);
            return redirect()->route('home');
    
        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
       
    }
}