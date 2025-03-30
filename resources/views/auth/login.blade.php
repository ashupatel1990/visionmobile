<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log In | Vision Mobile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
		<!-- App css -->
		<link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="{{ asset('assets/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
		<link href="{{ asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

		<!-- icons -->
		<link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="{{route('login')}}" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('assets/images/visionlogo-wb.png')}}" alt="" height="50">
                                            </span>
                                        </a>

                                        <a href="{{route('login')}}" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('assets/images/visionlogo-wb.png')}}" alt="" height="50">
                                            </span>
                                        </a>
                                    </div>
                                    <!-- <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p> -->
                                </div>
                                @include('include.alert')
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="email">Email:</label>
                                        <input class="form-control" type="email" id="email" name="email" value="{{old('email')}}" placeholder="Enter email" required autofocus autocomplete="username">
                                        @error('email')
                                            <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                                <li class="parsley-required">{{ $message}}</li>
                                            </ul>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password:</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password"
                                                required autocomplete="current-password"
                                                class="form-control" placeholder="Enter Password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="remember_me" checked>
                                            <label class="custom-control-label" for="checkbox-signin">{{ __('Remember me') }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit">{{ __('Log in') }}</button>
                                    </div>
                                </form>
                            </div> 
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                            {{-- @if (Route::has('password.request'))
                                <p> <a href="{{ route('password.request') }}" class="text-white-50 ml-1">{{ __('Forgot your password?') }}</a></p>
                            @endif --}}
                                <p class="text-white-50">Don't have an account? <a href="{{ route('register') }}" class="text-white ml-1"><b>{{ __('Sign Up') }}</b></a></p>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <footer class="footer footer-alt">
            2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a> 
        </footer> -->

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js')}}"></script>
        
    </body>
</html>