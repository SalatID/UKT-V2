<html>
    <head>
        <title>Absen</title>
        <style>
            /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
            .text-center{
                text-align: center;
            }
            .row.content {
                height: 1500px
            }
    
            h1 {
                font-size: 18px;
            }
            tr:nth-child(even) {
            background-color: #d0d0d0;
            }
            .table{
                border-collapse: collapse;
            }
            th,
            .border {
                padding: 3px;
                border: 1px solid black;
                font-size: 15px;
            }
    
            .no-border {
                border: none !important;
                padding: 0;
            }
    
    
            .page-break {
                page-break-after: always;
            }
    
            @media print {
                hr {
                    background: black !important;
                    -webkit-print-color-adjust: exact;
                }
    
                body {
                    width: 21cm !important;
                    height: 29.7cm !important;
                    display: table;
                    margin: 25px;
                }
            }
            @page{
                margin:25px;
            }
        </style>
    </head>
    <body>
        <div class="row col-12">
            <h1 class="text-center" style="margin:0;padding:0">{{ strtoupper('Absensi') }}</h1>
            <h4 class="text-center" style="margin:0;padding:0">{{$dataEvent->name}}-{{$dataEvent->lokasi}}-{{$dataEvent->penyelenggara}}</h4>
        </div>
        <br>
        <table width="100%" class="table">
            <tr>
                <td class="border text-center" rowspan="2">No</td>
                <td class="border text-center" rowspan="2">No Peserta</td>
                <td class="border text-center" rowspan="2">Nama Peserta</td>
                <td class="border text-center" rowspan="2">TS</td>
                <td class="border text-center" rowspan="2">Komwil</td>
                <td class="border text-center" rowspan="2">Unit</td>
                <td class="border text-center" rowspan="2">Tingkat</td>
                <td class="border text-center" rowspan="2">Tempat/Tanggal Lahir</td>
                <td class="border text-center" rowspan="2">Foto</td>
                <td class="border text-center" colspan="2">Absen</td>
            </tr>
            <tr>
                <td class="border text-center">Pergi</td>
                <td class="border text-center">Pulang</td>
            </tr>
           
            @php($i=1)
            @foreach($dataPeserta as $val)
            <tr>
                <td class="border text-center">{{$i++}}</td>
                <td class="border text-center">{{$val->no_peserta}}</td>
                <td class="border">{{ucwords(strtolower($val->name))}}</td>
                <td class="border">{{$val->data_ts->ts_code}}</td>
                <td class="border">{{$val->data_komwil->name}}</td>
                <td class="border">{{$val->data_unit->name}}</td>
                <td class="border">{{$val->tingkat}}</td>
                <td class="border">{{$val->tempat_lahir}}, <br>{{$val->tgl_lahir}}</td>
                <td class="border">
                    <div style="width: 2cm; height:3cm; border:solid black;">
                        <img src="{{ env('APP_ENV')=='production'?env('APP_URL'):public_path() }}/{{$val->foto}}" style="object-fit:contain" width="100%" height="100%" alt="">
                    </div>
                </td>
                <td class="border"></td>
                <td class="border"></td>
                
            </tr>
            @endforeach
        </table>
        <div class="page-break"></div>
    </body>
</html>