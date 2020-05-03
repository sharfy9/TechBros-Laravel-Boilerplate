@extends('layouts.app', [
    'namePage' => "List " . ucfirst(Str::plural(Request::segment(1))),
    'class' => 'sidebar-mini',
    'activePage' => Str::singular(Request::segment(1)),
    'activeNav' => '',
])

@section('content')
  <div class="panel-header">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <a class="btn btn-success btn-sm text-white pull-right" href="{{ route(Str::singular(Request::segment(1)).'.create') }}"><i class="fas fa-plus"></i></a>
            <h4 class="card-title">
              {{ __("List " . ucfirst(Str::plural(Request::segment(1))))}}
              {{-- ({{ Auth::user()->vendor->users->count()}}/{{ Auth::user()->vendor->allowed_users}}) --}}

            </h4>
          </div>
          <div class="card-body">
            <div class="toolbar">
              <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="table-responsive">
            <table id="myDataTable" class="table table-sm table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="w-auto">#</th>
                  <th class="w-auto">{{ __('Active') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Phone') }}</th>
                  <th>{{ __('Permissions') }}</th>
                  <th class="w-auto">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="w-auto">#</th>
                  <th class="w-auto">{{ __('Active') }}</th>
                  <th>{{ __('Name') }}</th>
                  <th>{{ __('Phone') }}</th>
                  <th>{{ __('Permissions') }}</th>
                  <th class="w-auto">{{ __('Actions') }}</th>
                </tr>
              </tfoot>
              <tbody></tbody>
            </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
@endsection
@section('customDataTable')
  oTable = $('#myDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'user',
        columns: [
          { data: 'sn', name: 'sn' },
          { data: 'active', name: 'active', orderable: false, searchable: false, addClass: "text-center" },
          { data: 'name', name: 'name' },
          { data: 'phone', name: 'phone' },
          { data: 'permissions', name: 'permissions' },
          { data: 'action', name: 'action', orderable: false, searchable: false },
      ],
      initComplete: function(settings, json){
        oTable.buttons().container().appendTo( '.toolbar' );
      }
    });
@endsection
