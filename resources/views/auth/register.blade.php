<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register & Signup | Vision Mobile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

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
                                <div class="text-center m-auto">
                                    <h3>Register Your User!</h3><br/>
                                </div>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input class="form-control" 
                                            name="name" 
                                            type="text" 
                                            value="{{old('name')}}" id="fullname" placeholder="Enter your name" 
                                            required autofocus autocomplete="name">
                                        @error('name')
                                            <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                                <li class="parsley-required">{{ $message}}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" 
                                            name="email" 
                                            type="email" 
                                            value="{{old('email')}}" id="emailaddress" required placeholder="Enter your email">
                                        @error('email')
                                            <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                                <li class="parsley-required">{{ $message}}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" 
                                                name="password" 
                                                class="form-control" 
                                                placeholder="Enter your password"
                                                required
                                                autocomplete="new-password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password')
                                            <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                                <li class="parsley-required">{{ $message}}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">{{ __('Confirm password') }}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password_confirmation" 
                                                name="password_confirmation" 
                                                class="form-control" 
                                                placeholder="confirm password"
                                                required
                                                autocomplete="new-password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password_confirmation')
                                            <ul class="parsley-errors-list filled" id="parsley-id-25" aria-hidden="false">
                                                <li class="parsley-required">{{ $message}}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                            <label class="custom-control-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> Sign Up </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Already have account?  <a href="{{ route('login') }}" class="text-white ml-1"><b>Sign In</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- <footer class="footer footer-alt">
            2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a> 
        </footer> -->

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js')}}"></script>
        
    </body>
</html>