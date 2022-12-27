<html>
    <head>
        <title>Formuir Penilaian Manual</title>
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
        @foreach($dataKelompok as $value)
        <div class="row col-12">
            <h1 class="text-center" style="margin:0;padding:0">{{ strtoupper('Formulir Penilaian Manual') }}</h1>
            <h4 class="text-center" style="margin:0;padding:0">{{$value->data_event->name}}-{{$value->data_event->lokasi}}-{{$value->data_event->penyelenggara}}</h4>
        </div>
        <br>
        <table width="100%">
            <tr>
                <td>Nama Kelompok</td>
                <td>:</td>
                <td>{{$value->name}}</td>
                <td>Tingkat Sabuk</td>
                <td>:</td>
                <td>{{$value->data_ts->name}}</td>
            </tr>
            <tr>
                <td>Penilai</td>
                <td>:</td>
                <td>{{$value->data_penilai->name??''}}</td>
            </tr>
        </table>
        <table width="100%" class="table">
            <tr>
                <td rowspan="2"class="border">No</td>
                <td rowspan="2"class="border">No Peserta</td>
                <td rowspan="2"class="border">Nama Peserta</td>
                <td rowspan="2"class="border">TS</td>
                <td class="border text-center" colspan="6">Nama Jurus</td>
            </tr>
            <tr>
                <td class="border" width="50px" height="70px"></td>
                <td class="border" width="50px" height="70px"></td>
                <td class="border" width="50px" height="70px"></td>
                <td class="border" width="50px" height="70px"></td>
                <td class="border" width="50px" height="70px"></td>
                <td class="border" width="50px" height="70px"></td>
            </tr>
            @php($i=1)
            @foreach($value->data_peserta as $val)
            <tr>
                <td class="border text-center">{{$i++}}</td>
                <td class="border text-center">{{$val->no_peserta}}</td>
                <td class="border">{{ucwords($val->name)}}</td>
                <td class="border">{{$val->data_ts->ts_code}}</td>
                <td class="border" width="50px"></td>
                <td class="border" width="50px"></td>
                <td class="border" width="50px"></td>
                <td class="border" width="50px"></td>
                <td class="border" width="50px"></td>
                <td class="border" width="50px"></td>
            </tr>
            @endforeach
        </table>
        <div class="page-break"></div>
        @endforeach
    </body>
</html>