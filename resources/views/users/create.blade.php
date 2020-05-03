@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'New ' . Str::singular(Request::segment(1)),
    'activePage' => Str::singular(Request::segment(1)),
    'activeNav' => '',
])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('New ' . Str::singular(Request::segment(1))) }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route(Str::singular(Request::segment(1)) . '.index') }}" class="btn btn-warning btn-sm">{{ __('Go Back') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route(Str::singular(Request::segment(1)) . '.store') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6> --}}
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                                    @include('inc.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                    @include('inc.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" id="input-phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}" required>

                                    @include('inc.feedback', ['field' => 'phone'])
                                </div>
                                <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-balance">{{ __('Balance') }}</label>
                                    <input type="number" name="balance" id="input-balance" class="form-control{{ $errors->has('balance') ? ' is-invalid' : '' }}" placeholder="{{ __('Balance') }}" value="{{ old('balance', 0) }}" required>

                                    @include('inc.feedback', ['field' => 'balance'])
                                </div>
                                @if (Auth::user()->hasRole("Super Admin"))
                                {{-- <div class="form-group">
                                    <label class="form-control-label" for="input-vendor_id">{{ __('Vendor') }}</label>
                                    <select name="vendor_id" id="vendor_id" class="form-control">
                                        <option value="0"></option>
                                        @foreach ($vendor as $item)
                                        <option value="{{$item->id}}">{{$item->id}}: {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @include('inc.feedback', ['field' => 'vendor_id'])
                                </div> --}}
                                @endif
                                <hr>

                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>

                                    @include('inc.feedback', ['field' => 'password'])
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="" required>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="input-password-permissions">{{ __('User Permissions') }}</label>
                                    @if (isset($permissions) && $permissions)
                                    <div class="row">
                                        <div class="form-check text-left">
                                            <label class="form-check-label">
                                                <input id="checkAllPermissions" class="form-check-input" type="checkbox">
                                                <span class="form-check-sign"></span>
                                                <div id="checkAllLabel">Check All Permissions</div>
                                            </label>
                                        </div>
                                    </div>
                                    @foreach ($permissions as $item)
                                    <div class="row">
                                        <div class="form-check text-left">
                                            <label class="form-check-label">
                                                <input class="form-check-input permissionCheck" name="permissions[]"
                                                    value="{{$item->id}}" type="checkbox">
                                                <span class="form-check-sign"></span>
                                                {{ucwords(str_replace(".", " ", $item->name))}}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('#checkAllPermissions').click(function(){
            if($(this).prop("checked") == true){
                $('.permissionCheck').prop('checked', true);
                $('#checkAllLabel').html("Uncheck All Permissions");
            }
            else if($(this).prop("checked") == false){
                $('.permissionCheck').prop('checked', false);
                $('#checkAllLabel').html("Check All Permissions");
            }
        });
    });
</script>

@endpush
