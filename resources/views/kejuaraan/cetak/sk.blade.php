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
            font-size: 12px;
            font-style: 'arial';
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
            /* background-image: url(/blangko_sertifikat/sbck.jpg); */
            background-size: contain;
            background-repeat: no-repeat;
        }

        td{
            font-size:15px !important;
            color: black;
        }

        @media print {
            hr {
                background: black !important;
                -webkit-print-color-adjust: exact;
            }

            #blangko {
                /* background-image: url(/blangko_sertifikat/sbck.jpg); */
                background-size: contain;
                background-repeat: no-repeat;

            }

            body {
                width: 21cm !important;
                height: 29cm !important;
                display: table;
            }
        }
        @page { margin: 12px; }
    </style>
</head>

<body style="padding:0;margin:0;">
        @foreach ($data as $item)
        @php($kategori =$item->label_weight)
            <div class="text-center d-table mb-3" id="blangko" style="width:20cm;display: inline-block;position: relative;">
                @if (false)
                    <img src="{{ public_path() }}/blangko_sertifikat/blangko_sk.jpg"
                        style="width:20cm;height:29cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                        alt="">
                @endif
                <div style="margin-top:22.2cm;margin-left:5.5cm;">
                    <div class="w-100" style="float:left">
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ucwords(strtolower($item->nama_peserta))}}</td>
                            </tr>
                            <tr>
                                <td>Juara</td>
                                <td>:</td>
                                <td>{{ ucwords(strtolower($item->juara)) }} Kategori {{ucwords(strtolower($kategori))}} {{str_replace("2","",str_replace("1","",ucwords(strtolower($item->kategori_usia))))}} {{ucwords(strtolower($item->jenis_kelamin))}}</td>
                            </tr>
                            <tr>
                                <td>Pelaksanaan</td>
                                <td>:</td>
                                <td>Jumat s.d Minggu, 02 s.d 04 Mei 2025</td>
                            </tr>
                            <tr>
                                <td>Tempat</td>
                                <td>:</td>
                                <td>Mall Bale Kota - Kota Tangerang</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        @endforeach

</body>

</html>
