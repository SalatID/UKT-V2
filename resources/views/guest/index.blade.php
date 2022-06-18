 <!DOCTYPE html>
 <html lang="en">
 <head>
   <title>Bootstrap Example</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
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
 <script type="text/javascript" src="/assets/js/jquery.js"></script>
 <script type="text/javascript">

 </script>
