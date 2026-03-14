<?php

namespace App\Actions\Admin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetAdminPassword implements ResetsUserPasswords
{
    public function reset(Admin $admin, array $input): void
    {
        Validator::make($input, [
            'password' => ['required','string','min:8','confirmed'],
        ])->validate();

        $admin->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}