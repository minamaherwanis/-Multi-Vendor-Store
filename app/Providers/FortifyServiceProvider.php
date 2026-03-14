<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Actions\Fortify\CreateUserWithType;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $request = request();

        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'web'); // نفس جدول users
            Config::set('fortify.passwords', 'users');
            Config::set('fortify.prefix', 'admin');
            Config::set('fortify.home', '/admin/dashboard');
        } else {
            Config::set('fortify.guard', 'web');
            Config::set('fortify.passwords', 'users');
            Config::set('fortify.prefix', '');
            Config::set('fortify.home', '/');
        }
    }

    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($request->is('admin/*') && $user->type !== 'admin') {
                    return null;
                }

                if (!$request->is('admin/*') && $user->type !== 'user') {
                    return null;
                }

                return $user;
            }
        });

        
 Fortify::createUsersUsing(\App\Actions\Fortify\CreateUserWithType::class);


        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // Rate Limiting
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        if (request()->is('admin/*')) {
            Fortify::viewPrefix('auth.'); 
        } else {
            Fortify::viewPrefix('front.auth.'); 
        }
    }
}