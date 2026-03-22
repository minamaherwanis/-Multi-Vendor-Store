<x-front-layout title="Confirm Password">

    <!-- Start Account Confirm Password Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('password.confirm') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Confirm Password</h3>
                                <p>This is a secure area of the application. Please confirm your password before continuing.</p>
                            </div>

                            @if ($errors->has('password'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <div class="form-group input-group">
                                <label for="reg-pass">Password</label>
                                <input class="form-control" type="password" name="password" id="reg-pass" required autocomplete="current-password">
                            </div>

                            <div class="button mt-3">
                                <button class="btn" type="submit">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Confirm Password Area -->

</x-front-layout>