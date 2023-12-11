<html>
    <head>
        <title>Peserta</title>
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
            .table{
                border-collapse: collapse;
            }
            tr:nth-child(even) {
            background-color: #d0d0d0;
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
        @php(ini_set("gd.jpeg_ignore_warning", 1))
        <div class="row col-12">
            <h1 class="text-center" style="margin:0;padding:0">{{ strtoupper('List Peserta') }}</h1>
            <h4 class="text-center" style="margin:0;padding:0">{{$dataEvent->name}}-{{$dataEvent->lokasi}}-{{$dataEvent->penyelenggara}}</h4>
        </div>
        <br>
        <table width="100%" class="table">
            <tr>
                <td class="border text-center">No</td>
                <td class="border text-center">No Peserta</td>
                <td class="border text-center">Nama Peserta</td>
                @if($form!="final")
                <td class="border text-center">TS</td>
                @else 
                <td class="border text-center">TS Awal</td>
                <td class="border text-center">TS Akhir</td>
                @endif
                <td class="border text-center">Komwil</td>
                <td class="border text-center">Unit</td>
                <td class="border text-center">Tingkat</td>
                <td class="border text-center">Tempat/Tanggal Lahir</td>
                @if($form!="final")
                <td class="border text-center">Kelompok</td>
                @endif
            </tr>           
            @php($i=1)
            @foreach($dataPeserta as $val)
            <tr>
                <td class="border text-center">{{$i++}}</td>
                <td class="border text-center">{{$val->no_peserta}}</td>
                <td class="border">{{ucwords(strtolower($val->name))}}</td>
                @if($form!="final")
                <td class="border">{{$val->data_ts->ts_code}}</td>
                @else 
                <td class="border">{{$val->data_ts->ts_code}}</td>
                <td class="border">{{$val->data_ts_akhir->ts_code}}</td>
                @endif
                <td class="border">{{$val->data_komwil->name}}</td>
                <td class="border">{{$val->data_unit->name}}</td>
                <td class="border">{{$val->tingkat}}</td>
                <td class="border">{{$val->tempat_lahir}}, <br>{{$val->tgl_lahir}}</td>
                @if($form!="final")
                <td class="border">{{$val->data_kelompok->name??'Belum Ada Kelompok'}}</td>     
                @endif           
            </tr>
            @endforeach
        </table>
        <div class="page-break"></div>
    </body>
</html>