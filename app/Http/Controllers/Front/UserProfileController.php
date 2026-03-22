<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;


class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('front.profile.edit', 
        [
            'user' => $user,
            'countries' => Countries::getNames('en'),
           'locales' => Languages::getNames(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2'],
            'local' => ['required', 'string', 'max:5'],

        ]);

        $user = $request->user();
        $profile = $user->profile;

        $profile->fill($request->only([
            'first_name',
            'last_name',
            'birthday',
            'gender',
            'country',
            'street_address',
            'city',
            'state',
            'postal_code',
            'local',
        ]));
        $profile->save();

        return to_route('home')->with('success', 'Profile Updated!');

    }
    public function destroy(Request $request)
    {
        $user = Auth::user();


             $user->delete();

        Auth::logout();

        return redirect('/')->with('danger', 'Account Deleted Successfully.');
    }


}
