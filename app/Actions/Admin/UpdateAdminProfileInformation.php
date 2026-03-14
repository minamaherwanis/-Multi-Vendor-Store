<?php

namespace App\Actions\Admin;
use App\Models\Admin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateAdminProfileInformation implements UpdatesUserProfileInformation
{
    public function update(Admin $admin, array $input): void
    {
        Validator::make($input, [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255', Rule::unique('admins')->ignore($admin->id)],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $admin->email && $admin instanceof MustVerifyEmail) {
            $this->updateVerifiedAdmin($admin, $input);
        } else {
            $admin->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    protected function updateVerifiedAdmin(Admin $admin, array $input): void
    {
        $admin->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $admin->sendEmailVerificationNotification();
    }
}