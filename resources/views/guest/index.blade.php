 <!DOCTYPE html>
 <html lang="en">
 <head>
   <title>UKT Online</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
   <script type="text/javascript" src="/assets/js/jquery.js"></script>
   <style>
     /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
     .row.content {height: 1500px}



     /* Set black background color, white text and some padding */
     footer {
       background-color: #555;
       color: white;
       padding: 15px;
       position: absolute;
    bottom: 0;
     }

     
   </style>
 </head>
 <body>

 <div class="container" style="padding:0 5vw;">
   <div class="row">
     <div class="col-xl-12 mb-4">
       <h4>Penilaian Ujian Kenaikan Tingkat Online</h4>
     </div>
     <div class="col-xl-12">
       <div class="table-responsive">
         <div class="container">
          @if(Session::has('error'))
          <div class="row">
              <div class="col-sm-12">
                  <div class="alert alert-{{Session::get('error')?'danger':'success'}} alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> {{Session::get('error')?'Failed':'Succes'}}!</h5>
                  {{Session::get('message')}}
                  @if(is_array(Session::get('data')))
                  <p>
                    @foreach (Session::get('data') as $item)
                        {{$item['message']}}, 
                    @endforeach
                  </p>
                  @endif
                  </div>
              </div>
          </div>
        @endif
           @yield('content')
         </div>
       </div>
     </div>
   </div>
 </div>

 <footer class="container mt-3">
    <p>Sistem Penilaian Ujian Kenaikan Tingkat Online</p>
    <p>&copy; PPS Satria Muda Indonesia Komwil Jakarta Barat</p>
  </footer>

 </body>
 </html>

 <script type="text/javascript">

 </script>
