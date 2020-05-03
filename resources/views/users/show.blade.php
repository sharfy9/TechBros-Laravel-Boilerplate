@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Customer Profile',
    'activePage' => 'customerProfile',
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
            <h5 class="title mb-0 pb-0">{{__("Bill History")}} <a href="{{ route(Str::singular(Request::segment(1)) . '.index') }}" class="btn btn-warning btn-sm">{{ __('Go Back') }}</a></h5>
            <span>Last 90 Days</span>
          </div>
          <div class="card-body">
            <div class="toolbar">
            </div>
            <div class="table-responsive">
            <table id="myDataTable" class="table table-sm table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="w-auto">#</th>
                  <th class="w-auto">{{ __('ID') }}</th>
                  <th>{{ __('Service') }}</th>
                  <th>{{ __('Amount') }}</th>
                  <th>{{ __('Date') }}</th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="w-auto">#</th>
                  <th class="w-auto">{{ __('ID') }}</th>
                  <th>{{ __('Service') }}</th>
                  <th>{{ __('Amount') }}</th>
                  <th>{{ __('Date') }}</th>
                  <th></th>
                </tr>
              </tfoot>
              <tbody>
                @if (isset($data->transactions) && $data->transactions)
                @foreach($data->transactions()->whereDate('paid_at', '>', Carbon\Carbon::now()->subDays(90))->get() as $item)
                  <tr>
                    <td></td>
                    <td>
                      <a href="{{route('bill.show',$item)}}">
                        #{{$item->id}}
                      </a>
                    </td>
                    <td>{{$item->description}}</td>
                    <td>{{ $item->amount }}Tk</td>
                    <td>{{ $item->created_at->format('d/m/y') }}</td>
                    <td></td>
                  </tr>
                @endforeach
                @endif

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
      <div class="col-md-4">
        <div class="card card-user">
          <div class="image">
            <img src="{{asset($data->active ? 'img/active.png' : 'img/inactive.png')}}" alt="...">
          </div>
          <div class="card-body">
            <div class="author">
              <a href="#">
                <img class="avatar border-gray" src="{{asset('assets')}}/img/default-avatar.png" alt="...">
                <h5 class="title">{{ $data->name }}</h5>
              </a>
              <p>Email: {{ $data->email }}
                <br>
                Balance: <b class="text-primary">{{ $data->balance }}Tk</b></p>
              @can('user.edit')
              <a href="{{route(Str::singular(Request::segment(1)).'.edit',$data)}}" class="btn btn-sm btn-block btn-primary">Edit</a>
              @endcan
              @can('activity.view.user')
              <a href="/activity/{{$data->id}}" class="btn btn-sm btn-block btn-info">View Activity</a>
              @endcan
            </div>
          </div>
          <hr>
          <p class="text-center text-muted text-sm">
            Last Updated At {{$data->updated_at->format('d/m/y h:iA')}}
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('jsbefore')
<script>
  var sumOfColumns = [3];
</script>
@endpush
