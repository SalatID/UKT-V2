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
            /* background-image: url(/blangko_sertifikat/sbck.jpg); */
            background-size: contain;
            background-repeat: no-repeat;
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
                height: 29.7cm !important;
                display: table;
            }
        }
        @page { margin: 12px; }
    </style>
</head>

<body style="padding:0;margin:0;">
        @foreach ($data as $item)
        @php($kategori = $item->label_weight)
            <div class="text-center d-table mb-3" id="blangko" style="display: inline-block;position: relative;width:29cm;">
                @if (false)
                    <img src="{{ public_path() }}/blangko_sertifikat/sbck.jpg"
                        style="width:29cm;height:20cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                        alt="">
                @endif
                <div style="margin-top:6.5cm;">
                    <div class="w-100" style="float:left">
                        <div class="row justify-content-center">
                            <h1 class="w-100 text-center" style="font-size:25px;">
                                {{ strtoupper($item->nama_peserta) }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div style="margin-top:2.5cm;">
                    <div class="w-100" style="float:left">
                        <div class="row justify-content-center">
                            <h1 class="w-100 text-center" style="font-size:25px;">
                                {{ strtoupper($item->juara) }} KATEGORI {{strtoupper($kategori)}} {{str_replace("2","",str_replace("1","",strtoupper($item->kategori_usia)))}} {{strtoupper($item->jenis_kelamin)}}
                            </h1>
                        </div>
                    </div>
                </div>
                <div style="margin-top:5.5cm;margin-left:10cm;">
                    <div class="w-100" style="float:left">
                        {{-- <img width="110px" src="{{ public_path() }}/blangko_sertifikat/stempel-3.png" alt=""> --}}
                    </div>
                </div>

            </div>
        @endforeach

</body>

</html>
