<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Str;
class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
public function callback($provider)
{
    $providerUser = Socialite::driver($provider)->user();

    // provider دور على حساب مرتبط بنفس 
    $user = User::where('provider', $provider)
        ->where('provider_id', $providerUser->getId())
        ->first();

    if (!$user) {

        //  دور على حساب بنفس الإيميل
        $user = User::where('email', $providerUser->getEmail())->first();

        if ($user) {
            // اربط الحساب الاجتماعي بالحساب القديم
            $user->update([
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'provider_token' => $providerUser->token,
            ]);
        } else {
            $email = $providerUser->getEmail() ?? Str::random(10) . '@facebook.com';

            //  إنشاء مستخدم جديد
            $user = User::create([
                'name' => $providerUser->getName() ?? $providerUser->getNickname(),
                 'email' => $email,
                'password' => Hash::make(Str::random(16)),
                'provider' => $provider,
                'provider_id' => $providerUser->getId(),
                'provider_token' => $providerUser->token,
            ]);
        }
    }

    auth()->login($user);

    return redirect()->route('home');
}


}
