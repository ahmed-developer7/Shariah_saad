@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <!-- Brand logo-->
                    <a class="brand-logo login-logo" href="{{url('/login')}}">
                        <img src="{{url('images/logo.png')}}" class="img-fluid" alt="Brand logo">
                    </a>
                    <!-- /Brand logo-->

                    <h4 class="card-title fw-bold mb-1">Shariyah Dashboard
                    </h4>
                    <p class="card-text mb-2">Please sign-in to your account</p>
                    <form class="auth-login-form mt-2" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="phone">Email</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control @error('email') is-invalid @enderror" id="phone" type="text" name="email"
                                       placeholder="Email"
                                       aria-describedby="phone" autofocus="" tabindex="1"/>
                                <span class="input-group-text" id="basic-addon5"><i data-feather="user"></i></span>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="mb-1">
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="password" type="password"
                                       name="password" placeholder="Password" aria-describedby="password"
                                       tabindex="2"/>
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" id="remember_me" value="remember_me" name="remember"
                                       type="checkbox" tabindex="3"/>
                                <label class="form-check-label" for="remember_me"> Remember Me</label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
                    </form>

                    <!-- /Login-->
                </div>
            </div>
            <!-- /Login basic -->
            <h3 class="btn or-text">Or continue with ...</h3>
            <a href="{{ route('login.microsoft') }}" class="btn outlook-btn"><img src="/images/ms-signin.png"></a>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    <script>
        $(function () {
            'use strict';

            var pageLoginForm = $('.auth-login-form');

            // jQuery Validation
            // --------------------------------------------------------------------
            if (pageLoginForm.length) {
                pageLoginForm.validate({
                    /*
                    * ? To enable validation onkeyup
                    onkeyup: function (element) {
                      $(element).valid();
                    },*/
                    /*
                    * ? To enable validation on focusout
                    onfocusout: function (element) {
                      $(element).valid();
                    }, */
                    rules: {
                        'email': {
                            required: true,
                            email: true
                        },
                        'password': {
                            required: true
                        }
                    }
                });
            }
        });
    </script>
@endsection
