<?php

namespace App\Actions\Admin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateAdminPassword implements UpdatesUserPasswords
{
    public function update(Admin $admin, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->after(function ($validator) use ($admin, $input) {
            if (! Hash::check($input['current_password'], $admin->password)) {
                $validator->errors()->add('current_password', 'The provided password does not match your current password.');
            }
        })->validateWithBag('updatePassword');

        $admin->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
