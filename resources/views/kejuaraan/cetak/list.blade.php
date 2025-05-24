@extends('kejuaraan.index')

@section('content')
    <div class="row">
        <form action="{{ route('kejuaraan.cetak') }}" method="GET" class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="namaKontingenF">Nama Kontingen</label>
                    <select id="namaKontingenF" class="form-control" name="nama_kontingen">
                        <option value="">Pilih Nama Kontingen</option>
                        @foreach (\App\Models\Kejuaraan\PesertaKejuaraan::nama_kontingen() as $item)
                            <option value="{{ $item->nama_kontingen }}"
                                {{ request('nama_kontingen') == $item->nama_kontingen ? 'selected' : '' }}>
                                {{ $item->nama_kontingen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="asalKontingenF">Asal Kontingen</label>
                    <select id="asalKontingenF" class="form-control">
                        <option value="">Pilih Asal Kontingen</option>
                        @foreach (\App\Models\Kejuaraan\PesertaKejuaraan::asal_kontingen() as $item)
                            <option value="{{ $item->asal_kontingen }}"
                                {{ request('asal_kontingen') == $item->asal_kontingen ? 'selected' : '' }}>
                                {{ $item->asal_kontingen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="kategoriUsiaF">Kategori Usia</label>
                    <select id="kategoriUsiaF" name="kategori_usia" class="form-control">
                        <option value="">Pilih Kategori Usia</option>
                        @foreach (\App\Models\Kejuaraan\PesertaKejuaraan::kategori_usia() as $item)
                            <option value="{{ $item->kategori_usia }}"
                                {{ request('kategori_usia') == $item->kategori_usia ? 'selected' : '' }}>
                                {{ $item->kategori_usia }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="kategoriPertandinganF">Kategori Pertandingan</label>
                    <select id="kategoriPertandinganF" name="id_weight" class="form-control">
                        <option value="">Pilih Kategori Pertandingan</option>
                        @foreach (\App\Models\Kejuaraan\Weight::get() as $item)
                            <option value="{{ $item->id }}" {{ request('id_weight') == $item->id ? 'selected' : '' }}>
                                {{ $item->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="namaPeserta">Nama Peserta</label>
                    <input type="text" class="form-control" name="nama_peserta"
                        value="{{ request('nama_peserta') ?? '' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="namaPelatih">Nama Pelatih</label>
                    <input type="text" class="form-control" name="nama_pelatih"
                        value="{{ request('nama_pelatih') ?? '' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" name="nik" value="{{ request('nik') ?? '' }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('kejuaraan.cetak') }}" class="btn btn-secondary">Reset</a>
            <button type="button" class="btn btn-warning" onclick="exportTableToPDF()">Export PDF</button>
        </form>

        <div class="col-12 d-flex justify-content-end">
            <button class="my-2 mx-3 btn btn-success" data-url="{{ route('kejuaraan.cetak.sertifikat') }}"
                onclick="cetak(this)">Cetak Sertfifikat</button>
            <button class="my-2 mx-3 btn btn-primary" data-url="{{ route('kejuaraan.cetak.sk') }}"
                onclick="cetak(this)">Cetak SK</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if (session()->has('error'))
                <div class="alert alert-{{ session()->get('error') ? 'danger' : 'success' }} alert-dismissible fade show"
                    role="alert">
                    <strong>{{ session()->get('message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <table class="table table-striped table-hover table-bordered" id="listTable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kontingen</th>
                        <th class="text-center">Asal Kontingen</th>
                        <th class="text-center">Nama Pelatih</th>
                        <th class="text-center">Nama Atlet</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Kategori Usia</th>
                        <th class="text-center">Kategori Pertandingan</th>
                        <th class="text-center">Juara</th>
                        <th class="text-center">Tanggal Cetak Sertifikat</th>
                        <th class="text-center">Tanggal Cetak SK</th>
                        <th class="text-center">Aksi</th>
                        <th class="text-center removeTd">
                            Pilih Semua
                            <br><input type="checkbox" class="cetak_semua" name="cetak_all" value="">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    <form action="#" method="POST" id="tableForm" target="_blank">
                        @csrf
                        @foreach ($data as $item)
                            @php($validateNik = \App\Models\Kejuaraan\PesertaKejuaraan::validate_nik($item->nik))
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_kontingen }}</td>
                                <td>{{ $item->asal_kontingen }}</td>
                                <td>{{ $item->nama_pelatih }}</td>
                                <td>{{ $item->nama_peserta }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>{{ $item->kategori_usia }}</td>
                                <td>
                                    {{ $item->label_weight ?? '' }}</td>
                                <td>
                                    <select name="juara[{{ $item->id }}]" class="form-control">
                                        <option value="">-Pilih Juara-</option>
                                        <option {{($item->juara??'')=='Juara 1'?'selected':''}} value="Juara 1">Juara 1</option>
                                        <option {{($item->juara??'')=='Juara 2'?'selected':''}} value="Juara 2">Juara 2</option>
                                        <option {{($item->juara??'')=='Juara 3'?'selected':''}} value="Juara 3">Juara 3</option>
                                        <option {{($item->juara??'')=='Peserta'?'selected':''}} value="Peserta">Peserta</option>
                                    </select>
                                </td>
                                <td>{{ $item->sertifikat_print_at ?? '' }}</td>
                                <td>{{ $item->sk_print_at ?? '' }}</td>
                                <td>
                                    <button type="button" data-data="{{ json_encode($item) }}"
                                        onclick="detail_peserta(this)" class="btn btn-success btn-small">Edit</button>
                                </td>
                                <td class="text-center">
                                    <input class="cetak" type="checkbox" name="cetak[{{ $item->id }}]">
                                </td>
                            </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editPeserta" tabindex="-1" role="dialog" aria-labelledby="editPesertaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPesertaLabel">Edit Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="{{ route('kejuaraan.validasi.edit') }}" method="POST" id="editForm">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="row">
                                <div class="col-6">

                                    <!-- Nama Kontingen -->
                                    <div class="form-group">
                                        <label for="namaKontingen">Nama Kontingen</label>
                                        <input type="text" class="form-control" id="namaKontingen"
                                            name="nama_kontingen" placeholder="Masukkan Nama Kontingen">
                                    </div>

                                    <!-- Asal Kontingen -->
                                    <div class="form-group">
                                        <label for="asalKontingen">Asal Kontingen</label>
                                        <input type="text" class="form-control" id="asalKontingen"
                                            name="asal_kontingen" placeholder="Masukkan Asal Kontingen">
                                    </div>

                                    <!-- Nama Pelatih -->
                                    <div class="form-group">
                                        <label for="namaPelatih">Nama Pelatih</label>
                                        <input type="text" class="form-control" id="namaPelatih" name="nama_pelatih"
                                            placeholder="Masukkan Nama Pelatih">
                                    </div>

                                    <!-- Nama Atlet -->
                                    <div class="form-group">
                                        <label for="namaAtlet">Nama Atlet</label>
                                        <input type="text" class="form-control" id="namaAtlet" name="nama_peserta"
                                            placeholder="Masukkan Nama Atlet">
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="form-group">
                                        <label for="jenisKelamin">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="jenisKelamin"
                                            name="jenis_kelamin" placeholder="Masukkan Jenis Kelamin">
                                    </div>


                                </div>
                                <div class="col-6">
                                    <!-- NIK -->
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik"
                                            placeholder="Masukkan NIK">
                                    </div>
                                    <!-- Kategori Usia -->
                                    <div class="form-group">
                                        <label for="kategoriUsia">Kategori Usia</label>
                                        <select class="form-control" id="kategoriUsia" name="kategori_usia">
                                            <option value="">Pilih Kategori Usia</option>
                                            @foreach (\App\Models\Kejuaraan\PesertaKejuaraan::kategori_usia() as $item)
                                                <option value="{{ $item->kategori_usia }}"
                                                    {{ request('kategori_usia') == $item->kategori_usia ? 'selected' : '' }}>
                                                    {{ $item->kategori_usia }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Kelas Sekolah -->
                                    <div class="form-group">
                                        <label for="kelasSekolah">Kelas Sekolah</label>
                                        <select class="form-control" id="kelasSekolah" name="kelas_sekolah">
                                            <option value="">Pilih Kelas Sekolah</option>
                                            @foreach (\App\Models\Kejuaraan\PesertaKejuaraan::kelas_sekolah() as $item)
                                                <option value="{{ $item->kelas_sekolah }}"
                                                    {{ request('kelas_sekolah') == $item->kelas_sekolah ? 'selected' : '' }}>
                                                    {{ $item->kelas_sekolah }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Berat Badan -->
                                    <div class="form-group">
                                        <label for="beratBadan">Berat Badan</label>
                                        <input type="text" class="form-control" id="beratBadan" name="berat_badan"
                                            placeholder="Masukkan Berat Badan">
                                    </div>

                                    <!-- Kategori Pertandingan -->
                                    <div class="form-group">
                                        <label for="kategoriPertandingan">Kategori Pertandingan</label>
                                        <select class="form-control" id="kategoriPertandingan" name="id_weight">
                                            <option value="">Pilih Kategori Pertandingan</option>
                                            @foreach (\App\Models\Kejuaraan\Weight::get() as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Usia -->
                                    <div class="form-group">
                                        <label for="usia">Usia</label>
                                        <input type="text" class="form-control" id="usia" name="usia"
                                            placeholder="Masukkan Usia">
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#editForm').submit()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
