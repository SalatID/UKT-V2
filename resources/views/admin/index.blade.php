<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UKT Online | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins')}}/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins')}}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins')}}/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/admin')}}/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins')}}/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins')}}/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins')}}/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins')}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('plugins')}}/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('plugins')}}/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins')}}/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('plugins')}}/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- jQuery -->
  <script src="{{asset('plugins')}}/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('plugins')}}/jquery-ui/jquery-ui.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{asset('plugins')}}/datatables/jquery.dataTables.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="{{asset('plugins')}}/jszip/jszip.min.js"></script>
  <script src="{{asset('plugins')}}/pdfmake/pdfmake.min.js"></script>
  <script src="{{asset('plugins')}}/pdfmake/vfs_fonts.js"></script>
  <script src="{{asset('plugins')}}/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="{{asset('plugins')}}/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- Select2 -->
  <script src="{{asset('plugins')}}/select2/js/select2.full.min.js"></script>
  <style>
    .floating-search-result{
      position: absolute;
      width: 95%;
      padding: 2%;
      border-radius: 10px;
      background: #fff;
      border: solid gray;
      z-index: 99;
    }
  </style>
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets')}}/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('inc.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('inc.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="row justify-content-start">
              <h1 class="m-0 mr-2">@yield('title')</h1>
              @if(auth()->user()->role=='SPADM')
              @php($eventSelect = \App\Models\EventMaster::all())
              <select name="event_select" class="form-contro form-control-sm" data-src={{url()->current()}}>
                <option value="">Pilih Event</option>
                @foreach ($eventSelect as $item)
                <option value="{{ $item->event_alias }}" {{(request('event_alias')??'')==$item->event_alias?'selected':''}}>
                  {{ $item->name }} - {{ $item->lokasi }} -
                  {{ $item->penyelenggara }}</option>
                @endforeach
              </select>
              @endif
            </div>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @yield('breadcrumb')
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row {{session()->has('error')?'':'d-none'}} div-error">
              <div class="col-sm-12">
                  <div class="alert div-alert alert-{{session()->get('error')?'danger':'success'}} alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> <span class="div-title">{{session()->get('error')?'Failed':'Succes'}}!</span></h5>
                  <span class="div-message">{{session()->get('message')}}</span>
                  @if(is_array(session()->get('data')))
                  <p>
                    @foreach (session()->get('data') as $item)
                        {{$item['message']}}, 
                    @endforeach
                  </p>
                  @endif
                  </div>
              </div>
          </div>
       @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('inc.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('plugins')}}/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('plugins')}}/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('plugins')}}/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('plugins')}}/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins')}}/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins')}}/moment/moment.min.js"></script>
<script src="{{asset('plugins')}}/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins')}}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('plugins')}}/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins')}}/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/admin')}}/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets/admin')}}/js/demo.js"></script>
<script>
  function showAllerJs(data)
  {
    $('.div-alert').addClass((data.error?'alert-danger':'alert-success'))
    $('.div-title').text((data.error?'Failed':'Sucess'))
    $('.div-message').text(data.message)
    $('.div-error').removeClass('d-none')
  }
  $('#komwil').change(function(){
        e = $(this);
        changeKomwil(this)
    })
    function changeKomwil(e)
    {
      e=$(e)
      $.get(e.data('href')+'?id='+e.val(),function(data){
        if(data.length > 0){
            var html = '<option value="">Pilih Unit</option>'
            html += data.map(function(d){
                return '<option value="'+d.id+'">'+d.name+'</option>'
            })
            $('select[name="unit_id"]').html(html).promise().done(function(){
            $('select[name="unit_id"]').attr('disabled',false)
            if(typeof e.data('unit_id')!=='undefined') $('select[name="unit_id"]').val(e.data('unit_id'))
            })
            return
        }
        $('select[name="unit_id"]').attr('disabled',true)
        })
    }
    function formatDate(date,separator) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join(separator);
    }
    $('select[name="event_select"]').change(function(){
      if($(this).val()=='') {
        window.location.href = $(this).data('src')
        return
      }
      window.location.href =$(this).data('src')+'?event_alias='+$(this).val()
    })
    
</script>
</body>
</html>
