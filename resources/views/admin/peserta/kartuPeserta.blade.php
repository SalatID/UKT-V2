<html>

<head>
    <title>Cetak Kartu Peserta</title>
    <link rel="stylesheet" href="{{public_path()}}/assets/css/bootstrap.min.css">
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }
        body{
            margin:10px;
        }
        @page{
            margin: 10px;
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
        .page-break {
            page-break-after: always;
        }
        @media print {
            hr {
                background:black !important;
                -webkit-print-color-adjust: exact; 
            }
            body {
                width: 21cm !important;
                height: 29.7cm !important;
                display: table;
            }
        }
    </style>
</head>

<body style="padding:0;margin:0;">
    @php($i=0)
    <div class="container-fluid" style="width:21cm;">
        @foreach($dataPeserta as $item)
            <div style="width:85mm;height:52mm; border:3px solid black;margin:8px;display:block;float:unset">
                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                    PANITIA {{strtoupper($item->data_event->name)}}
                </h1>
                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                    {{strtoupper($item->data_event->penyelenggara)}}
                </h1>
                <h1 class="col-12 m-0 p-0 text-center" style="font-size:10px">
                    {{date('d F Y',strtotime($item->data_event->tgl_mulai))}} s.d {{date('d F Y',strtotime($item->data_event->tgl_selesai))}} di {{strtoupper($item->data_event->lokasi)}}
                </h1>
                <hr style="background:black;height: 3px;" class="p-0 m-0">
                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:70px">
                    {{strtoupper($item->no_peserta)}}
                </h1>
                <div class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                    {{strtoupper($item->name)}}
                </div>
            </div>
            @php($i++)
            @if($i==5)
            <div class="page-break"></div>
            @php($i=0)
            @endif
        @endforeach
    </div>
</body>
<script>
    
</script>

</html>
