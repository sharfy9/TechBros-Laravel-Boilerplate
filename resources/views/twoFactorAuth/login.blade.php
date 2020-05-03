@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => '2FA Setup',
'activePage' => '2fa',
'activeNav' => '',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card ">
                <div class="card-header text-center">
                    <h5 class="title">{{__("2 Factor Authentication")}}</h5>
                </div>
                <div class="card-body text-center">
                    <form role="form" method="POST" action="{{ route('2fa') }}">
                        @csrf
                        <div
                            class="input-group no-border form-control-lg {{ $errors->has('one_time_password') ? ' has-danger' : '' }}">
                            <span class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="now-ui-icons users_circle-08"></i>
                                </div>
                            </span>
                            <input class="form-control {{ $errors->has('one_time_password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('One Time Password') }}" type="text" name="one_time_password"
                                value="{{ old('one_time_password') }}" required autofocus>
                        </div>
                        @if ($errors->has('one_time_password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('one_time_password') }}</strong>
                        </span>
                        @endif
                        <button type="submit"
                            class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Log in') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection