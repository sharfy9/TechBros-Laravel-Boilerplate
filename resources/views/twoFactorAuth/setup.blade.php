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
          <h5 class="title">{{__("Set up 2 Factor Authentication")}}</h5>
        </div>
        <div class="card-body text-center">
            <p>
                Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code 
                <br>
                <a href="{{$link}}">
                  {{ $secret }}
                </a> <br>
                Click on the code to email it to your inbox.
            </p>
                <img src="{{ $qr }}">
            <p class="text-danger">You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
            <form method="POST">
                @csrf
                <input type="hidden" name="secret" value="{{$secret}}">
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Did you complete the setup? Otherwise you will not be able to login.');">Complete Setup</button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block" href="/profile">Cancel Setup</a>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection