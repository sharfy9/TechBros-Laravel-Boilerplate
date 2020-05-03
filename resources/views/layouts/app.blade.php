<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('inc.meta')
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
    <title>
        {{(isset($namePage) && $namePage) ? "$namePage | " : ""}}{{config('app.name')}}
    </title>
    <!-- CSS Files -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('assets') }}/demo/demo.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('js/fakeLoader.min.js') }}"></script>
    <link href="{{ asset('css/fakeLoader.min.css') }}" rel="stylesheet" />
    @stack('css')
</head>

<body class="{{ $class ?? '' }}">
    <div class="fakeLoader"></div>
    <script>
        $.fakeLoader({
        timeToHide:1000,
        bgColor:"#3498db",
        spinner:"spinner4"
      });
    </script>
    <div class="wrapper">
        @auth
        @include('layouts.auth')
        @endauth
        @guest
        @include('layouts.guest')
        @endguest
    </div>
    @include('inc.alerts')
    <script>
        var csrf_token = "{{csrf_token()}}";
    </script>
    @stack('jsbefore')
    <!--   Core JS Files   -->
    <script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets') }}/demo/demo.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/hotkeys.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('jsbefore')
    <script>
        $(document).bind('keydown', 'ctrl+q', function(e){
      if($('#headerSearchInput').length > 0) {
        $('#headerSearchInput').focus();
      }
    });
    $.extend( true, $.fn.dataTable.defaults, {
      "searching": true,
      "stateSave": true,
      "buttons": {
        buttons: [
        {
            extend: 'print',
            customize: function ( win ) {
                $(win.document.body)
                    .css( 'font-size', '10pt' )
                    .css( 'margin', 'auto' )
                    .css( 'text-align', 'center' )
                    .css( 'padding', '50px' )
                    .css( 'margin', '50px' );
                $(win.document.body).find( 'table' )
                    .addClass( 'compact table-condensed' )
                    .css( 'font-size', 'inherit' );
            }
        }, 'pdf', 'colvis'],
        dom: {
          button: {
            className: 'btn btn-sm btn-secondary'
          }
        }
      },
      "stateSaveParams": function (settings, data) {
        data.search.search = "";
      },
      "columnDefs": [ {
              "searchable": false,
              "orderable": false,
              "targets": [0, -1]
          },
          { "className": "text-right", "targets": [ -1 ] } ],
          "order": [[ 1, 'desc' ]],
          "footerCallback": function() {
            if(typeof sumOfColumns != 'undefined')
            {
              getColumnSum(sumOfColumns);
            }
          }
    });
    if($('#myDataTable').length > 0) {
      @hasSection('customDataTable')
      //lalala
      @yield('customDataTable')
      @else
      oTable = $('#myDataTable').DataTable({});
      oTable.buttons().container().appendTo( '.toolbar' );
      @endif
      $('#headerSearchInput').on("input", function(){
        oTable.search($(this).val()).draw();
      })
      oTable.on( 'order.dt search.dt', function () {
        oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
      } ).draw();
    }
    </script>
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>
    @stack('js')
</body>

</html>
