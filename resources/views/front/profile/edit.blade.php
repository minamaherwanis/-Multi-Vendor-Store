<x-front-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <form action="{{ route('front.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white shadow rounded">
                    @method('patch')
                    @csrf

          
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name"
                                   value="{{ old('first_name', $user->profile->first_name) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name"
                                   value="{{ old('last_name', $user->profile->last_name) }}"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" name="birthday" id="birthday"
                                   value="{{ old('birthday', $user->profile->birthday) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Gender</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                       {{ old('gender', $user->profile->gender) == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                       {{ old('gender', $user->profile->gender) == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="street_address" class="form-label">Street Address</label>
                            <input type="text" name="street_address" id="street_address"
                                   value="{{ old('street_address', $user->profile->street_address) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city"
                                   value="{{ old('city', $user->profile->city) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" name="state" id="state"
                                   value="{{ old('state', $user->profile->state) }}"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code"
                                   value="{{ old('postal_code', $user->profile->postal_code) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label">Country</label>
                            <select name="country" id="country" class="form-select">
                                @foreach($countries as $key => $value)
                                    <option value="{{ $key }}" {{ old('country', $user->profile->country) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="local" class="form-label">Local</label>
                            <select name="local" id="local" class="form-select">
                                @foreach($locales as $key => $value)
                                    <option value="{{ $key }}" {{ old('local', $user->profile->local) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>


                <div class="text-center mt-3">
                    <form action="{{ route('front.profile.destroy') }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete your account?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-5">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-front-layout>