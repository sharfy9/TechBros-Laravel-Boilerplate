@extends('layouts.app', [
'namePage' => ucfirst(Str::plural(Request::segment(1))),
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

          @can('activity.view.all')
          <a class="btn btn-success btn-sm text-white pull-right"
          href="{{ ($mode == 'my') ? "/activity/all" : "/activity" }}">{{ __(($mode == 'my') ? "Show All" : "Show My") }}</a>
          @endcan
          <h4 class="card-title">{{ __("List " . ucfirst(Str::plural(Request::segment(1))))}}</h4>
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
                <th>{{ __('Time') }}</th>
                <th class="w-auto">{{ __('ID') }}</th>
                <th>{{ __('Subject:ID') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Causer') }}</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="w-auto">#</th>
                <th>{{ __('Time') }}</th>
                <th class="w-auto">{{ __('ID') }}</th>
                <th>{{ __('Subject:ID') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Causer') }}</th>
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
        ajax: '{{Request::url()}}',
        columns: [
          { data: 'sn', name: 'sn' },
          { data: 'time', name: 'time' },
          { data: 'id', name: 'id' },
          { data: 'subject', name: 'subject' },
          { data: 'description', name: 'description' },
          { data: 'causer', name: 'causer' }
      ],
      initComplete: function(settings, json){
        oTable.buttons().container().appendTo( '.toolbar' );
      }
    });
@endsection
