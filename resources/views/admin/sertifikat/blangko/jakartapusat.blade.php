<html>

<head>
    <title>Cetak Sertifikat</title>
    <link rel="stylesheet" href="{{ public_path() }}/assets/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ public_path() }}/assets/js/jquery.js"></script>
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }

        * {
            font-size: 18px;
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

        #blangko {
            /* background-image: url(/blangko_sertifikat/jakartapusat.jpg); */
            background-size: contain;
            background-repeat: no-repeat;
        }

        @media print {
            hr {
                background: black !important;
                -webkit-print-color-adjust: exact;
            }

            #blangko {
                /* background-image: url(/blangko_sertifikat/jakartapusat.jpg); */
                background-size: contain;
                background-repeat: no-repeat;

            }

            body {
                width: 21cm !important;
                height: 29.7cm !important;
                display: table;
            }
        }
        @page { margin: 12px; }
    </style>
</head>

<body style="padding:0;margin:0;">
    @if ($data == 'off')
        <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
            <img src="{{ public_path() }}/blangko_sertifikat/jakartapusat.jpg"
                style="width:29cm;height:20cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                alt="">
        </div>
    @else
        @php($romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'])
        @php($bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        @foreach ($dataSertifikat as $item)
            <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
                @if ($blangko == 'on')
                    <img src="{{ public_path() }}/blangko_sertifikat/jakartapusat.jpg"
                        style="width:29cm;height:20cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                        alt="">
                @endif
                <div style="margin-top:2.7cm;width:29.2cm;">
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:25px;">
                            {{ $item->no_sertifikat ?? $item->data_peserta->no_peserta.'/UKT/SMI-JKB/' . $romawi[date('n', strtotime($item->data_peserta->data_event->tgl_mulai))] . '/' . date('Y', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                        </h1>
                    </div>

                </div>
                <div style="margin-top:6.5cm;width:32.5cm;">
                    <div class="w-25" style="float:left;margin-top:-50px">
                        <div style="width:3cm;height:4cm;margin-left:50px;">
                            <img src="{{ env('APP_ENV')=='production'?env('APP_URL'):public_path() }}/{{ $foto == 'on' ? $item->data_peserta->foto : 'assets/img/3x4.png' }}"
                                alt="" style="width:3cm;height:4cm;object-fit:cover">
                        </div>
                    </div>
                    <div class="w-50" style="float:left">
                        <div class="row justify-content-center">
                            <h1 class="w-100 text-center" style="font-size:25px;">
                                {{ $item->data_peserta->name }}
                            </h1>
                        </div>
                    </div>
                    <div class="w-100" style="margin-top: 47px">
                        <table style="margin-left:480px;">
                            <tr>
                                <td width="300">{{ $item->data_peserta->tempat_lahir }},
                                    {{ date('d', strtotime($item->data_peserta->tgl_lahir)) }}
                                    {{ $bulan[date('n', strtotime($item->data_peserta->tgl_lahir))-1] }}
                                    {{ date('Y', strtotime($item->data_peserta->tgl_lahir)) }}</td>
                            </tr>
                            <tr>
                                <td width="300" >{{ $item->data_peserta->data_unit->name }}</td>
                            </tr>
                            <tr>
                                <td width="300" >{{ $item->data_peserta->data_komwil->name }}</td>
                            </tr>
                            <tr>
                                <td width="300" >{{ $item->data_peserta->data_ts->name }}</td>
                            </tr>
                            <tr>
                                <td width="300" >{{ $item->data_peserta->data_ts_akhir->name ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <p class="text-center" style="width: 30cm;margin-top:5px;"> <span
                                class="font-weight-bold">{{ $item->data_peserta->data_event->lokasi }}</span>
                            pada tanggal : <span
                                class="font-weight-bold">{{ date('d', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                                - {{ date('d', strtotime($item->data_peserta->data_event->tgl_selesai)) }}
                                {{ $bulan[date('n', strtotime($item->data_peserta->data_event->tgl_selesai))-1] }}
                                {{ date('Y', strtotime($item->data_peserta->data_event->tgl_selesai)) }}</span></span>
                        </p>
                    </div>
                </div>

            </div>
        @endforeach
    @endif

</body>

</html>
