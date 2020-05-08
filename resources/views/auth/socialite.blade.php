@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'Complete Registration',
'activePage' => 'socialite',
'activeNav' => '',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{__(" Complete Registration")}}</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="/complete-registration" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label>{{__(" Phone")}}</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', auth()->user()->phone) }}"
                                        placeholder="Phone Number">
                                    @include('inc.feedback', ['field' => 'phone'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{__(" New password")}}</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('New Password') }}" type="password" name="password" required>
                                    @include('inc.feedback', ['field' => 'password'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{__(" Confirm New Password")}}</label>
                                    <input class="form-control" placeholder="{{ __('Confirm New Password') }}"
                                        type="password" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-primary btn-round">{{__('Save')}}</button>
                        </div>
                        <hr class="half-rule" />
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="image">
                    <img src="{{asset('assets')}}/img/bg5.jpg" alt="...">
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="#">
                            <img class="avatar border-gray" src="{{asset('assets')}}/img/default-avatar.png" alt="...">
                            <h5 class="title">{{ auth()->user()->name }}</h5>
                        </a>
                        <p class="description">
                            <span><b>{{ auth()->user()->email }}</b></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
