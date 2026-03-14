<?php
namespace App\Actions\Admin;
use App\Models\Admin;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;
class AuthenticateAdmin
{
    public function authenticate($request){
        $username=$request->post(config('fortify.username'));
        $password=$request->post('password');
        $user=Admin::where('username','=',$username)
        ->orwhere('email','=',$username)
        ->orwhere('phone_number','=',$username)
        ->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return false;
    }
}

