<html>

<head>
    <title>Cetak Sertifikat</title>
    {{-- <link rel="stylesheet" href="{{ public_path() }}/assets/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ public_path() }}/assets/js/jquery.js"></script> --}}
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .text-center{
            text-align: center;
        }
        .row.content {
            height: 1500px
        }
        .col-12{
            width: 100%;
        }
        h1 {
            font-size: 18px;
        }

        th,
        td {
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
            }
        }
    </style>
</head>

<body style="padding:10px;margin:0;">
    @php
        $jurus = ['Standar SMI', 'Tradisional', 'Prasetya Pesilat', 'Beladiri Praktis'];
        $td = ['Aerobik', 'Fisik Teknik', 'Kuda-kuda Dasar', 'Serang Hindar'];
        $detail = new \App\Models\SummaryNilaiDetail();
    @endphp
    @foreach ($dataSertifikat as $item)
        @php
            $dataDetail = $item->data_detail->toArray();
            $fTd = array_filter($dataDetail, function ($key) use ($td) {
                return in_array($key['nama_jurus'], $td) !== false;
            });
            $fJurus = array_filter($dataDetail, function ($key) use ($jurus) {
                return in_array($key['nama_jurus'], $jurus) !== false;
            });
            $sumJurus =[];
            $sumTs = [];
        @endphp
        <div class="text-center mb-3">
            <div class="row col-12">
                <h1 class="text-center">{{ strtoupper('HASIL NILAI UJIAN KENAIKAN TINGKAT') }}</h1>
            </div>
            <div class="row col-12">
                <h1 class="text-center">
                    {{ strtoupper('PERGURUAN PENCAK SILAT SATRIA MUDA INDONESIA') }}<br>
                    {{ strtoupper('KOMISARIAT DAERAH DKI JAKARTA') }}
                </h1>
            </div>
            <div class="row col-12 mt-3">
                <table style="margin-left:100px">
                    <tr>
                        <td class="no-border" width="100">Nama</td>
                        <td class="no-border" width="5">:</td>
                        <td width="300" class="font-weight-bold no-border">{{$item->data_peserta->name??''}}</td>
                    </tr>
                    <tr>
                        <td class="no-border" width="100">Tingkatan Sabuk</td>
                        <td class="no-border" width="5">:</td>
                        <td class="no-border" width="300">{{$item->data_peserta->data_ts->name??''}}</td>
                    </tr>
                </table>
            </div>
            <div class="row col-12 mt-3">
                <h1 style="margin-left:100px" class="text-left">I. Teknik Dasar</h1>
                <table border="1" style="border-collapse: collapse;margin-left:100px">
                    <thead>
                        <tr>
                            <th class="text-center" width="10">NO</th>
                            <th class="text-center" width="170">MATERI</th>
                            <th class="text-center" width="80">NILAI</th>
                            <th class="text-center" width="100">KRITERIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no=1)
                        @foreach ($fTd as $i)
                        @php(array_push($sumTs,$i['nilai']))
                            <tr>
                                <td width="10" class="text-center">{{$no++}}</td>
                                <td width="170">{{ $i['nama_jurus'] }}</td>
                                <td class="text-center" width="80">{{number_format(round($i['nilai'],1),1) }}</td>
                                <td width="100" class="font-weight-bold text-center">{{ $i['kriteria'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center font-weight-bold" colspan="2">TOTAL</td>
                            <td class="text-center font-weight-bold">{{number_format(round(array_sum($sumTs),1),1)}}</td>
                            <td class="text-center font-weight-bold" rowspan="2">{{$detail->criteria(count($fTd)>0?array_sum($sumTs)/count($fTd):0)}}</td>
                        </tr>
                        <tr>
                            <td class="text-center font-weight-bold" colspan="2">NILAI RATA-RATA</td>
                            <td class="text-center font-weight-bold">{{number_format(round(count($fTd)>0?array_sum($sumTs)/count($fTd):0,1),1)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row col-12 mt-3">
                <h1 style="margin-left:100px" class="text-left">II. Jurus</h1>
                <table border="1" style="border-collapse: collapse;margin-left:100px">
                    <thead>
                        <tr>
                            <th class="text-center" width="10">NO</th>
                            <th class="text-center" width="170">MATERI</th>
                            <th class="text-center" width="80">NILAI</th>
                            <th class="text-center" width="100">KRITERIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no=1)
                        @foreach ($fJurus as $d)
                        @php(array_push($sumJurus,$d['nilai']))
                            <tr>
                                <td width="10" class="text-center">{{$no++}}</td>
                                <td width="170">{{ $d['nama_jurus'] }}</td>
                                <td class="text-center" width="80">{{number_format(round($d['nilai'],1),1) }}</td>
                                <td width="100" class="font-weight-bold text-center">{{ $d['kriteria'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center font-weight-bold" colspan="2">TOTAL</td>
                            <td class="text-center font-weight-bold">{{number_format(round(array_sum($sumJurus),1),1)}}</td>
                            <td class="text-center font-weight-bold" rowspan="2">{{$detail->criteria(count($fJurus)>0?array_sum($sumJurus)/count($fJurus):0)}}</td>
                        </tr>
                        <tr>
                            <td class="text-center font-weight-bold" colspan="2">NILAI RATA-RATA</td>
                            <td class="text-center font-weight-bold">{{number_format(round(count($fJurus)>0?array_sum($sumJurus)/count($fJurus):0,1),1)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row col-12 mt-3">
                <h1 style="margin-left:10px" class="text-center">Mengetahui,</h1>
                <table border="1" width="1" style="border-collapse: collapse;margin-left:30px">
                    <thead>
                        <tr>
                            <td width="130">
                               <strong>Dindin Djuandi</strong>
                                <br>
                               <span style="font-size : 11px">Dewan Guru</span> 
                            </td>
                            <td width="100"></td>
                            <td width="130">
                                <strong>Dindin Djuandi</strong>
                                 <br>
                                <span style="font-size : 11px">Dewan Guru</span> 
                             </td>
                             <td width="100"></td>
                        </tr>
                        <tr>
                            <td width="130">
                               <strong>Wagianto</strong>
                                <br>
                               <span style="font-size : 11px">Pendekar Muda Utama</span> 
                            </td>
                            <td width="100"></td>
                            <td width="130">
                                <strong>Jarsa Purnama Desa</strong>
                                 <br>
                                <span style="font-size : 11px">Pendekar Muda Utama</span> 
                             </td>
                             <td width="100"></td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row col-12 mt-3">
                <table width="1" style="border-collapse: collapse;margin-left:150px">
                    <thead>
                        <tr>
                            <td style="border:none" class="text-center" width="300">
                              Ketua<br>
                              PPS Satria Muda Indonesia<br>
                              Komisariat Daerah DKI Jakarta<br>
                              <br>
                              <br>
                              <br>
                              <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none" class="text-center" width="300">
                                <strong>Prof. Dr. Ir. H. Sufmi Dasco Ahmad, S.H., M.H</strong>
                            </td>
                            
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="page-break"></div>
    @endforeach

</body>

</html>
