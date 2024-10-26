<html>

<head>
    <title>Silat Benteng Cisadane Kids</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <style>
        /* Centering the login box */
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
        }

        .table th,
        .table td {
            padding: 4px 4px;
            /* Ubah nilai ini untuk menyesuaikan padding */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">SBCK 2024</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @php($k = new \App\Http\Controllers\KejuaraanController())
            @php($menuH = $k->getMenu())
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('kejuaraan.home') }}">Home <span
                            class="sr-only">(current)</span></a>
                </li>
                @foreach ($menuH as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $item['src'] }}">{{ $item['nama'] }}</a>
                    </li>
                @endforeach
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <label for="">{{ request()->session()->get('nama_validator') ?? '' }}</label>
            </form>
        </div>
    </nav>
    <nav class="content container-fluid px-4">
        @yield('content')
    </nav>
</body>
<script>
    $(document).ready(function() {
        // Event listener untuk checkbox "sudah_validasi_all"
        $('input[name="sudah_validasi_all"]').change(function() {
            // Set semua checkbox dengan nama "sudah_validasi" sesuai status "sudah_validasi_all"
            $('.sudah_validasi').prop('checked', this.checked);
            $('.sudah_validasi_input').val(this.checked ? 'Y' : 'N');
        });
        $('input[name="sudah_bayar_all"]').change(function() {
            // Set semua checkbox dengan nama "sudah_bayar" sesuai status "sudah_bayar_all"
            $('.sudah_bayar').prop('checked', this.checked);
            $('.sudah_bayar_input').val(this.checked ? 'Y' : 'N');
        });
        $('.sudah_bayar').change(function() {
            $(this).parent().find('.sudah_bayar_input').val(this.checked ? 'Y' : 'N')
        })
        $('.sudah_validasi').change(function() {
            $(this).parent().find('.sudah_validasi_input').val(this.checked ? 'Y' : 'N')
        })
    });

    function detail_peserta(t) {
        data = $(t).data('data')
        console.log(data)
        $("input[name='id']").val(data.id);
        $('#namaKontingen').val(data.nama_kontingen);
        $('#asalKontingen').val(data.asal_kontingen);
        $('#namaPelatih').val(data.nama_pelatih);
        $('#namaAtlet').val(data.nama_peserta);
        $('#jenisKelamin').val(data.jenis_kelamin);
        $('#nik').val(data.nik);
        $('#kategoriUsia').val(data.kategori_usia);
        $('#kelasSekolah').val(data.kelas_sekolah);
        $('#beratBadan').val(data.berat_badan);
        $('#kategoriPertandingan').val(data.weight.id);
        $('#usia').val(data.usia);
        $('#editPeserta').modal('show')
    }
    function hapus_peserta(t){
        if (confirm('Hapus Data Ini?')){
            window.location.href = $(t).data('url')
        }
    }
</script>

</html>
