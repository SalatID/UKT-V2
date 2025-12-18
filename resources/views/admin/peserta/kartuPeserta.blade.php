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
        
        .kartu {
            width: 85mm;
            height: 52mm;
            border: 3px solid black;
            margin: 1mm;
            float: left;
            box-sizing: border-box;
        }

        .clear {
            clear: both;
        }

        .page-break {
            page-break-after: always;
            clear: both;
        }
    </style>
</head>

<body style="padding:0;margin:0;">
   @php
        $col = 0;
        $perPage = 10; // 2 kolom x 3 baris
        $count = 0;
    @endphp

    <div style="width:21cm;padding-left:1cm;padding-top:1cm">

    @foreach($dataPeserta as $item)

        <div class="kartu">
            <h1 class="text-center font-weight-bold" style="font-size:15px;margin:0">
                PANITIA {{ strtoupper($item->data_event->name) }}
            </h1>
            <h1 class="text-center font-weight-bold" style="font-size:15px;margin:0">
                {{ strtoupper($item->data_event->penyelenggara) }}
            </h1>
            <div class="text-center" style="font-size:10px">
                {{ date('d F Y',strtotime($item->data_event->tgl_mulai)) }}
                s.d
                {{ date('d F Y',strtotime($item->data_event->tgl_selesai)) }}
                di {{ strtoupper($item->data_event->lokasi) }}
            </div>

            <hr style="background:black;height:3px;margin:2px 0">

            <div class="text-center font-weight-bold" style="font-size:70px;line-height:1">
                {{ $item->no_peserta }}
            </div>

            <div class="text-center font-weight-bold" style="font-size:15px">
                {{ strtoupper($item->name) }}
            </div>
        </div>

        @php
            $col++;
            $count++;
        @endphp

        {{-- SETIAP 2 KARTU → BARIS BARU --}}
        @if($col == 2)
            <div class="clear"></div>
            @php $col = 0; @endphp
        @endif

        {{-- SETIAP 6 KARTU → HALAMAN BARU --}}
        @if($count == $perPage)
            <div class="page-break"></div>
            @php $count = 0; @endphp
        @endif

    @endforeach
    </div>
</body>
<script>
    
</script>

</html>
