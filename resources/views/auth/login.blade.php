@extends('layouts.auth')
@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card o-hidden border-0 shadow-lg my-5  card-bg-custom">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pt-5 pl-5 pr-5 pb-3">
                                <div class="text-center">
                                    <h1 class="h4 text-white mb-4">{{ __('Welcome Back! Login now') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" id="login" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <input type="email" class="form-control  " name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control  " name="password" placeholder="{{ __('Password') }}" required>
                                    </div>

                                    <x-captcha/>

                                    <div class="form-group">
                                        <button type="submit"
                                        class="btn btn-primary   btn-block">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    {{-- <div class="form-group">
                                        <button type="button" class="btn btn-github   btn-block">
                                            <i class="fab fa-github fa-fw"></i> {{ __('Login with GitHub') }}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" class="btn btn-twitter   btn-block">
                                            <i class="fab fa-twitter fa-fw"></i> {{ __('Login with Twitter') }}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" class="btn btn-facebook   btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> {{ __('Login with Facebook') }}
                                        </button>
                                    </div> --}}
                                </form>


                                @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    </div>
                                @endif

                                @if (Route::has('input.aan'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('input.aan') }}">{{ __('Create an Account!') }}</a>
                                    </div>
                                @endif
                                <div class="from-group text-center mt-4">
                                    <a href="/" class="text-white">Back to BRUMULTIVERSE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
