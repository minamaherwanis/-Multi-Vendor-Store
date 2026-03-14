<?php

namespace App\Actions\Admin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewAdmin implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered admin.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Admin
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255','unique:admins'],
            'password' => ['required','string','min:8','confirmed'],
        ])->validate();

        return Admin::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}