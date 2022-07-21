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
            /* background-image: url(/blangko_sertifikat/jakartabarat.png); */
            background-size: contain;
            background-repeat: no-repeat;
        }

        @media print {
            hr {
                background: black !important;
                -webkit-print-color-adjust: exact;
            }

            #blangko {
                /* background-image: url(/blangko_sertifikat/jakartabarat.png); */
                background-size: contain;
                background-repeat: no-repeat;

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
    @if ($data == 'off')
        <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
            <img src="{{ public_path() }}/blangko_sertifikat/jakartabarat.png"
                style="width:19cm;height:27cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                alt="">
        </div>
    @else
        @php($romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'])
        @php($bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        @foreach ($dataSertifikat as $item)
            <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;">
                @if ($blangko == 'on')
                    <img src="{{ public_path() }}/blangko_sertifikat/jakartabarat.png"
                        style="width:19cm;height:27cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                        alt="">
                @endif
                <div style="margin-top:8.5cm;width:19cm;">
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:16px;">Nomor :
                            {{ $item->data_peserta->no_peserta }}{{ $item->no_sertifikat ?? '/UKT/SMI-JKB/' . $romawi[date('n', strtotime($item->data_peserta->data_event->tgl_mulai))] . '/' . date('Y', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                        </h1>
                    </div>
                    <div class="row justify-content-center">
                        <h1 class="w-100 text-center" style="font-size:16px;">Diberikan kepada :</h1>
                    </div>
                    <div class="w-100">
                        <table style="margin-left:100px">
                            <tr>
                                <td width="200">Nama</td>
                                <td width="5">:</td>
                                <td width="300" class="font-weight-bold">{{ $item->data_peserta->name }}</td>
                            </tr>
                            <tr>
                                <td width="200">Tempat/Tanggal Lahir</td>
                                <td width="5">:</td>
                                <td width="300">{{ $item->data_peserta->tempat_lahir }},
                                    {{ date('d', strtotime($item->data_peserta->tgl_lahir)) }}
                                    {{ $bulan[date('n', strtotime($item->data_peserta->tgl_lahir))] }}
                                    {{ date('Y', strtotime($item->data_peserta->tgl_lahir)) }}</td>
                            </tr>
                            <tr>
                                <td width="200">Tingkatan Sabuk</td>
                                <td width="5">:</td>
                                <td width="300">{{ $item->data_peserta->data_ts->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <p class="text-center" style="width: 20cm">
                            <span class="font-weight-bold">
                                TELAH MENGIKUTI {{ strtoupper($item->data_peserta->data_event->name) }}<br>
                                {{ strtoupper($item->data_peserta->data_event->penyelenggara) }}<br>
                            </span>
                            yang diselenggarakan di : <span
                                class="font-weight-bold">{{ $item->data_peserta->data_event->lokasi }}</span><br>
                            pada tanggal : <span
                                class="font-weight-bold">{{ date('d', strtotime($item->data_peserta->data_event->tgl_mulai)) }}
                                - {{ date('d', strtotime($item->data_peserta->data_event->tgl_selesai)) }}
                                {{ $bulan[date('n', strtotime($item->data_peserta->data_event->tgl_selesai))] }}
                                {{ date('Y', strtotime($item->data_peserta->data_event->tgl_selesai)) }}</span><br>
                            berhasil <span class="font-weight-bold">LULUS </span> Ke Tingkat Sabuk<br>
                            <span class="font-weight-bold">{{ $item->data_peserta->data_ts_akhir->name ?? '' }}</span>
                        </p>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <table style="margin-left:170px">
                            <tr>
                                <td style="vertical-align: bottom;" class="p-2">
                                    <div style="width:3cm;height:4cm;">
                                        <img src="{{ env('APP_ENV')=='production'?env('APP_URL'):public_path() }}/{{ $foto == 'on' ? $item->data_peserta->foto : 'assets/img/3x4.png' }}"
                                            alt="" style="width:3cm;height:4cm;object-fit:cover">
                                    </div>
                                </td>
                                <td class="text-center">
                                    Disahkan Oleh <br>
                                    Ketua PPS Satria Muda Indonesia<br>
                                    Komwil Jakarta Barat
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <strong>Ir. Indra Madya Permana</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        @endforeach
    @endif

</body>

</html>
