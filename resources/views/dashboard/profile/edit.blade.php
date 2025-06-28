@extends('layouts.dashboard')

@section('title')
    <h1>Edit Profile</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
    <x-alert type="success" />
    <x-alert type="info" />
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @method('patch')
    @csrf

    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="first_name" label="First Name" :value="old('first_name', $user->profile->first_name)" />
        </div>
        <div class="col-md-6">
            <x-form.input name="last_name" label="Last Name" :value="old('last_name', $user->profile->last_name)" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="birthday" type="date" label="Birthday" :value="old('birthday', $user->profile->birthday)" />
        </div>
        <div class="col-md-6">
            <x-form.radio 
                name="gender"  
                :options="['male'=>'Male','female'=>'Female']" 
                label="Gender" 
                :checked="old('gender', $user->profile->gender)" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="street_address" label="Street Address" :value="old('street_address', $user->profile->street_address)" />
        </div>
        <div class="col-md-4">
            <x-form.input name="city" label="City" :value="old('city', $user->profile->city)" />
        </div>
        <div class="col-md-4">
            <x-form.input name="state" label="State" :value="old('state', $user->profile->state)" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="postal_code" label="Postal Code" :value="old('postal_code', $user->profile->postal_code)" />
        </div>
        <div class="col-md-4">
            <x-form.select name="country" label="Country" :options="$countries" :selected="old('country', $user->profile->country)" />
        </div>
        <div class="col-md-4">
            <x-form.select name="local" :options="$locales" label="Local" :selected="old('local', $user->profile->local)" />
        </div>
    </div>

   <button class="btn btn-primary">Save</button>

</form>
@endsection
