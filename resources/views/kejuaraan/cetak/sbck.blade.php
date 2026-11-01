<html>

<head>
    @php
        $pathPemasalan = public_path() ."/blangko_sertifikat/pemasalan.png";
        $typePemasalan = pathinfo($pathPemasalan, PATHINFO_EXTENSION);
        $dataImgPemasalan = file_get_contents($pathPemasalan);
        $base64Pemasalan = 'data:image/' . $typePemasalan . ';base64,' . base64_encode($dataImgPemasalan);

        $pathPrestasi = public_path() ."/blangko_sertifikat/prestasi.png";
        $typePrestasi = pathinfo($pathPrestasi, PATHINFO_EXTENSION);
        $dataImgPrestasi = file_get_contents($pathPrestasi);
        $base64Prestasi = 'data:image/' . $typePrestasi . ';base64,' . base64_encode($dataImgPrestasi);

        $pathPemasalanFull = public_path() ."/blangko_sertifikat/pemasalan-full.png";
        $typePemasalan = pathinfo($pathPemasalanFull, PATHINFO_EXTENSION);
        $dataImgPemasalanFull = file_get_contents($pathPemasalanFull);
        $base64PemasalanFull = 'data:image/' . $typePemasalan . ';base64,' . base64_encode($dataImgPemasalanFull);

        $pathPrestasiFull = public_path() ."/blangko_sertifikat/prestasi-full.png";
        $typePrestasi = pathinfo($pathPrestasiFull, PATHINFO_EXTENSION);
        $dataImgPrestasiFull = file_get_contents($pathPrestasiFull);
        $base64PrestasiFull = 'data:image/' . $typePrestasi . ';base64,' . base64_encode($dataImgPrestasiFull);

    @endphp
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

        .blangko {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center -0.5cm; /* geser ke atas */
        }

        .pemasalan {
                background-image: url('{{ $base64Pemasalan }}');
        }

        .prestasi {
            background-image: url('{{ $base64Prestasi }}');
        }

        .pemasalan-full {
            background-image: url('{{ $base64PemasalanFull }}');
        }

        .prestasi-full {
            background-image: url('{{ $base64PrestasiFull }}');
        }

        @media print {
            hr {
                background: black !important;
                -webkit-print-color-adjust: exact;
            }

            .blangko {
                /* background-image: url(/blangko_sertifikat/sbck.jpg); */
                background-position: center -0.5cm; /* geser ke atas */
                background-size: cover;
                background-repeat: no-repeat;
                /* background-size: contain;
                background-repeat: no-repeat; */

            }

            .pemasalan {
                background-image: url('{{ $base64Pemasalan }}');
            }

            .prestasi {
                background-image: url('{{ $base64Prestasi }}');
            }

            .pemasalan-full {
                background-image: url('{{ $base64PemasalanFull }}');
            }

            .prestasi-full {
                background-image: url('{{ $base64PrestasiFull }}');
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

<body style="padding-left:2.5cm;margin:0;">
    
        @foreach ($data as $item)
        @php($kategori = $item->label_weight)
            <div class="text-center d-table mb-3 blangko {{ $item->kategori_usia == 'USIA DINI 1' ? 'pemasalan-' : 'prestasi-' }}" style="display: inline-block;position: relative;width:29cm;height:96%;">
                @if (true)
                        {{-- @if($item->kategori_usia=="Usia Dini 1")
                            <img src="{{ public_path() }}/blangko_sertifikat/pemasalan.png"
                                style="width:29cm;height:20cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                                alt="">
                        @else
                            <img src="{{ public_path() }}/blangko_sertifikat/prestasi.png"
                                style="width:29cm;height:20cm;position:absolute;padding:0;margin:0;z-index:-1;pointer-events: none;"
                                alt="">
                        @endif --}}
                @endif
                <div style="padding-top:4.2cm;">
                    <div class="w-100" style="float:left">
                        <div class="row justify-content-center">
                            <p class="w-100 text-center" style="font-size:15px;">
                               @if (strtolower($item->juara) != 'peserta')
                                    Nomor : B/HK.08.03/10.15.{{ strtoupper($item->no_sertifikat) }}/SET/X/2026
                                    @else
                                    Nomor : 030/SBCKC/II/X/2026
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div style="padding-top:3cm;">
                    <div class="w-100" style="float:left">
                        <div class="row justify-content-center">
                            <h1 class="w-100 text-center" style="font-size:25px;">
                                {{ strtoupper($item->nama_peserta) }}
                            </h1>
                        </div>
                    </div>
                </div>
                <div style="padding-top:3cm;">
                    <div class="w-100" style="float:left">
                        <div class="row justify-content-center">
                            <h1 class="w-100 text-center" style="font-size:25px;">
                                {{ strtoupper($item->juara) }} KATEGORI {{strtoupper($kategori)}} {{str_replace("2","",str_replace("1","",strtoupper($item->kategori_usia)))}} {{strtoupper($item->jenis_kelamin)}}
                            </h1>
                        </div>
                    </div>
                </div>
                <div style="padding-top:5cm;padding-right:14cm; display:none">
                    <div class="w-100" style="float:left">
                        <img width="200px" src="{{ public_path() }}/kejuaraan/ttd_menpora.jpg" alt="">
                    </div>
                </div>

            </div>
        @endforeach

</body>

</html>
