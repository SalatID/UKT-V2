<html>

<head>
    <title>Cetak Sertifikat</title>
    {{-- <link rel="stylesheet" href="{{ public_path() }}/assets/css/bootstrap.min.css"> --}}
    {{-- <script type="text/javascript" src="{{ public_path() }}/assets/js/jquery.js"></script> --}}
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif
        }
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }
        .row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .text-center{
            text-align: center;
        }
        .font-weight-bold{
            font-weight: bold;
        }
        * {
            font-size: 18px;
        }

        br{
            display: block;
            margin-bottom: 5px;
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
        @page { margin: 20px; }
        body { margin: 0px; }
        .justify-content-center {
            justify-content: center!important;
        }
        #blangko {
            /* background-image: url(/blangko_sertifikat/komda-dki.png); */
            background-size: contain;
            background-repeat: no-repeat;
        }

        @media print {
            hr {
                background: black !important;
                -webkit-print-color-adjust: exact;
            }

            #blangko {
                /* background-image: url(/blangko_sertifikat/komda-dki.png); */
                background-size: contain;
                background-repeat: no-repeat;

            }

            body {
                width: 21cm !important;
                height: 29.7cm !important;
                display: table;
            }
        }
        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body style="padding:0;margin:0;">
    @php($romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'])
    @php($bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
    @if ($data == 'off')
        <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
            <img src="{{ public_path() }}/blangko_sertifikat/komda-dki.png"
                style="width:20cm;height:29cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                alt="">
                <div style="margin-top:9cm;margin-left:0.5cm;width:19cm;">
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:16px;">
                        </h1>
                    </div>
                    <br>
                    
                    <div class="w-100" style="height: 4.4cm">
                    </div>
                    <div class="row justify-content-center">
                        <p class="text-center" style="width: 20cm">
                            <span class="font-weight-bold">
                                TELAH MENGIKUTI {{ strtoupper($dataSertifikat[0]->data_peserta->data_event->name) }}<br>
                                {{ strtoupper($dataSertifikat[0]->data_peserta->data_event->penyelenggara) }}<br>
                            </span>
                            yang diselenggarakan di : <span
                                class="font-weight-bold">{{ $dataSertifikat[0]->data_peserta->data_event->lokasi }}</span><br>
                            pada tanggal : 
                            @if($dataSertifikat[0]->data_peserta->data_event->tgl_mulai==$dataSertifikat[0]->data_peserta->data_event->tgl_selesai)
                                <span
                                class="font-weight-bold">{{ date('d', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_mulai)) }}
                                {{ $bulan[date('n', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_selesai))-1] }}
                                {{ date('Y', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_selesai)) }}</span><br>
                            @else
                            <span
                                class="font-weight-bold">{{ date('d', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_mulai)) }}
                                - {{ date('d', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_selesai)) }}
                                {{ $bulan[date('n', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_selesai))-1] }}
                                {{ date('Y', strtotime($dataSertifikat[0]->data_peserta->data_event->tgl_selesai)) }}</span><br>
                            @endif
                            berhasil <span class="font-weight-bold">LULUS </span> Ke Tingkat Sabuk<br>
                            <span class="font-weight-bold"></span>
                        </p>
                    </div>
                    <div class="row justify-content-center" style="margin-top: 50px">
                        <table style="margin-left:170px">
                            <tr>
                                <td style="vertical-align: bottom;" class="p-2">
                                    <div style="width:3cm;height:4cm;">
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    Disahkan Oleh <br>
                                    Ketua PPS Satria Muda Indonesia<br>
                                    Komisariat Daerah DKI Jakarta
                                    <div style="height: 3cm;">

                                    </div>
                                    <strong style="font-size:15px;">Prof. Dr. Ir. H. Sufmi Dasco Ahmad, S.H., M.H</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
        </div>
    @else
       
        @foreach ($dataSertifikat as $item)
            <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
                @if ($blangko == 'on')
                    <img src="{{ public_path() }}/blangko_sertifikat/komda-dki.png"
                        style="width:20cm;height:29cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                        alt="">
                @endif
                <div style="margin-top:9cm;margin-left:0.5cm;width:19cm;">
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:16px;">Nomor :
                            {{ $item->no_sertifikat ?? $item->data_peserta->no_peserta.'/UKT/SMI-JKB/' . $romawi[date('n', strtotime($item->data_peserta->data_event->tgl_mulai))] . '/' . date('Y', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                        </h1>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:16px;">Diberikan kepada :</h1>
                    </div>
                    <div class="w-100">
                        <table style="margin-left:100px">
                            <tr>
                                <td width="150">Nama</td>
                                <td width="5">:</td>
                                <td width="300" class="font-weight-bold">{{ strtoupper($item->data_peserta->name) }}</td>
                            </tr>
                            <tr>
                                <td width="150">Tempat/Tanggal Lahir</td>
                                <td width="5">:</td>
                                <td width="300">{{ $item->data_peserta->tempat_lahir }},
                                    {{ date('d', strtotime($item->data_peserta->tgl_lahir)) }}
                                    {{ $bulan[date('n', strtotime($item->data_peserta->tgl_lahir))-1] }}
                                    {{ date('Y', strtotime($item->data_peserta->tgl_lahir)) }}</td>
                            </tr>
                            <tr>
                                <td width="150">Tingkatan Sabuk</td>
                                <td width="5">:</td>
                                <td width="300">{{ $item->data_peserta->data_ts->name }}</td>
                            </tr>
                            <tr>
                                <td width="150">Komwil</td>
                                <td width="5">:</td>
                                <td width="300">{{ $item->data_peserta->data_komwil->name }}</td>
                            </tr>
                        </table>
                    </div>
                   
                    <div class="row justify-content-center">
                        <p class="text-center" style="width: 20cm">
                            @if ($blangko == 'on')
                            <span class="font-weight-bold">
                                TELAH MENGIKUTI {{ strtoupper($item->data_peserta->data_event->name) }}<br>
                                {{ strtoupper($item->data_peserta->data_event->penyelenggara) }}<br>
                            </span>
                            yang diselenggarakan di : <span
                                class="font-weight-bold">{{ $item->data_peserta->data_event->lokasi }}</span><br>
                            pada tanggal : 
                            @if($item->data_peserta->data_event->tgl_mulai==$item->data_peserta->data_event->tgl_selesai)
                                <span
                                class="font-weight-bold">{{ date('d', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                                {{ $bulan[date('n', strtotime($item->data_peserta->data_event->tgl_selesai))-1] }}
                                {{ date('Y', strtotime($item->data_peserta->data_event->tgl_selesai)) }}</span><br>
                            @else
                            <span
                                class="font-weight-bold">{{ date('d', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                                - {{ date('d', strtotime($item->data_peserta->data_event->tgl_selesai)) }}
                                {{ $bulan[date('n', strtotime($item->data_peserta->data_event->tgl_selesai))-1] }}
                                {{ date('Y', strtotime($item->data_peserta->data_event->tgl_selesai)) }}</span><br>
                            @endif
                            berhasil <span class="font-weight-bold">LULUS </span> Ke Tingkat Sabuk<br>
                            @endif
                            @if($blangko != 'on')
                            <div style="height: 3cm">

                            </div>
                            @endif
                            <span class="font-weight-bold" >{{ strtoupper($item->data_peserta->data_ts_akhir->name ?? '') }}</span>
                        </p>
                    </div>
                   
                    @if($blangko != 'on')
                    <div style="height: 2cm">

                    </div>
                    @endif
                    <div class="row justify-content-center" style="margin-top: 15px">
                        <table style="margin-left:170px">
                            <tr>
                                <td style="vertical-align: bottom;" class="p-2">
                                    <div style="width:3cm;height:4cm;">
                                        <img src="{{ env('APP_ENV')=='production'?env('APP_URL'):public_path() }}/{{ $foto == 'on' ? $item->data_peserta->foto : 'assets/img/3x4.png' }}"
                                            alt="" style="width:3cm;height:4cm;object-fit:cover">
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($blangko == 'on')
                                    Disahkan Oleh <br>
                                    Ketua PPS Satria Muda Indonesia<br>
                                    Komisariat Daerah DKI Jakarta
                                    <div style="height: 3cm;">

                                    </div>
                                    <strong style="font-size:15px;">Prof. Dr. Ir. H. Sufmi Dasco Ahmad, S.H., M.H</strong>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                </div>

            </div>
            <div class="page-break"></div>
        @endforeach
    @endif

</body>

</html>