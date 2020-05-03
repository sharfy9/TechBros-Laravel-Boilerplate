@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'User Profile',
'activePage' => 'profile',
'activeNav' => '',
])

@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                @can('profile.change.info')
                <div class="card-header">
                    <h5 class="title">{{__(" Edit Profile")}}</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label>{{__(" Name")}}</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', auth()->user()->name) }}">
                                    @include('inc.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label>{{__(" Phone")}}</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', auth()->user()->phone) }}">
                                    @include('inc.feedback', ['field' => 'phone'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__(" Email address")}}</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                    @include('inc.feedback', ['field' => 'email'])
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group">
                                    <label for="activeSwitch">{{__(" Active")}}</label>
                                    <div class="custom-control custom-switch ml-1">
                                        <input type="checkbox" name="active" class="custom-control-input activeSwitch" id="activeSwitch" />
                                        <label class="custom-control-label" for="activeSwitch"></label>
                                    </div>
                                    @include('inc.feedback', ['field' => 'active'])
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-primary btn-round">{{__('Save')}}</button>
                        </div>
                        <hr class="half-rule" />
                    </form>
                </div>
                @endcan
                @can('profile.change.password')
                <div class="card-header">
                    <h5 class="title">{{__("Password")}}</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-7 pr-1">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{__(" Current Password")}}</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="old_password" placeholder="{{ __('Current Password') }}" type="password"
                                        required>
                                    @include('inc.feedback', ['field' => 'old_password'])
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
                            <button type="submit" class="btn btn-primary btn-round ">{{__('Change Password')}}</button>
                        </div>
                    </form>
                </div>
                @endcan
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
                            Balance: <span class="text-primary"><b>{{ auth()->user()->balance }}Tk</b></span>
                        </p>
                        @can('activity.view.own')
                        <a href="/activity" class="btn btn-sm btn-block btn-primary">Activity Log</a>
                        @endcan
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    @if (Auth::user()->google2fa_secret == null)
                    <div class="alert alert-danger text-center" role="alert">
                        <p>2 Factor Authentication is disabled.</p>
                        <a href="/2fa/setup" class="btn btn-success">Setup 2FA</a>
                    </div>
                    @else
                    <div class="alert alert-success text-center" role="alert">
                        <p>2 Factor Authentication is enabled.</p>
                        <div class="row">
                            <div class="col-lg-6 mx-0 px-0">
                                <a href="/2fa/setup" class="btn btn-primary">Modify 2FA</a>
                            </div>
                            <div class="col-lg-6 mx-0 px-0">
                                <a href="/2fa/disable" class="btn btn-danger">Disable 2FA</a>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
