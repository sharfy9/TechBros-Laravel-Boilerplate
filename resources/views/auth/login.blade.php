@extends('layouts.app', [
'namePage' => 'Login page',
'class' => 'login-page sidebar-mini ',
'activePage' => 'login',
'backgroundImage' => asset('assets') . "/img/bg14.jpg",
])

@section('content')
<div class="content">
    <div class="container">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="header bg-gradient-primary py-10 py-lg-2 pt-lg-12">
                <div class="container">
                    <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-9">
                                <p class="text-lead text-light mt-3 mb-0">
                                    @include('inc.migrations_check')
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ml-auto mr-auto">
            <form role="form" id="{{ getFormId() }}" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card card-login card-plain">
                    <div class="card-body ">
                        <div
                            class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <span class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </span>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Email or Phone Number') }}" type="text" name="email"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                        <div
                            class="input-group no-border form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input placeholder="Password"
                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                placeholder="{{ __('Password') }}" type="password" required>
                        </div>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                        <div>
                            {!! htmlFormButton(__('Login'), [
                                    "type"=>"submit",
                                    "class"=>"btn btn-primary btn-round btn-lg btn-block mb-3"
                                ]) !!}
                            <div class="pull-left">
                                <h6>
                                    <a href="{{ route('register') }}"
                                        class="link footer-link">{{ __('Create Account') }}</a>
                                </h6>
                            </div>
                            <div class="pull-right">
                                <h6>
                                    <a href="{{ route('password.request') }}"
                                        class="link footer-link">{{ __('Forgot Password?') }}</a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    @if (config('techbros.socialite.active'))
                    <div class="card-footer text-center">
                        <h6>
                            <a class="link">Login with</a>
                        </h6>
                        <div class="social">
                            @foreach (config('techbros.socialite.services') as $item => $color)
                            <a href="/redirect/{{$item}}">
                                <button type="button" {!!$color ? "style='background-color: {$color};'" : '' !!}
                                    class="btn btn-icon btn-round btn-{{$item}}">
                                    <i class="fab fa-{{$item}}"></i>
                                </button>
                            </a>
                            &nbsp;
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();
        });
</script>
@endpush
