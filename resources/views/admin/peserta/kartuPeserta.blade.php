<html>

<head>
    <title>Cetak Kartu Peserta</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }
        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
            position: 'fixed';
            bottom: 0;
            width: 100% !important;
            text-align: 'center';
        }
        @media print {
            hr {
                background:black !important;
                -webkit-print-color-adjust: exact; 
            }
        }
    </style>
</head>

<body style="padding:0;margin:0;">
    <div style="width:21cm;height:29.7cm;backgroud:red;" onload="">
        @foreach($dataPeserta as $item)
        <div style="width:92mm;height:58mm; border:3px solid black;float:left;margin:8px">
            <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                PANITIA {{strtoupper($item->data_event->name)}}
            </h1>
            <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                {{strtoupper($item->data_event->penyelenggara)}}
            </h1>
            <h1 class="col-12 m-0 p-0 text-center" style="font-size:10px">
                {{date('d F Y',strtotime($item->data_event->tgl_mulai))}} s.d {{date('d F Y',strtotime($item->data_event->tgl_selesai))}} di {{strtoupper($item->data_event->lokasi)}}
            </h1>
            <hr style="background:black;height: 3px;" class="p-0 m-0 px-2 mt-1">
            <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:90px">
                {{strtoupper($item->no_peserta)}}
            </h1>
            <div class="col-12 m-0 p-0 text-center font-weight-bold">
                {{strtoupper($item->name)}}
            </div>
        </div>
        @endforeach
    </div>
</body>
<script>
        window.print()
</script>

</html>
