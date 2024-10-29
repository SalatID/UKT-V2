@extends('kejuaraan.index')

@section('content')
    <div class="row">
        <form action="{{ route('kejuaraan.validasi') }}" method="GET" class="col-12">
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
                    <label for="namaPeserta">Validasi Bayar</label>
                    <select name="sudah_bayar" class="form-control" id="">
                        <option value="">Pilih Status</option>
                        <option value="Y" {{ request('sudah_bayar') == 'Y' ? 'selected' : '' }}>Sudah</option>
                        <option value="N" {{ request('sudah_bayar') == 'N' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="namaPeserta">Validasi Data</label>
                    <select name="sudah_validasi" class="form-control" id="">
                        <option value="">Pilih Status</option>
                        <option value="Y" {{ request('sudah_validasi') == 'Y' ? 'selected' : '' }}>Sudah</option>
                        <option value="N" {{ request('sudah_validasi') == 'N' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>
                <div class="form-row col-md-6 px-4">
                    <div class="form-check col">
                        <input class="form-check-input" type="checkbox" name="nikBelumValid" id="NIKBelumValid" {{ request('nikBelumValid') == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="NIKBelumValid">
                            NIK Belum Valid
                        </label>
                    </div>
                    <div class="form-check col">
                        <input class="form-check-input" type="checkbox" name="bbKosong" id="bbKosong" {{ request('bbKosong') == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="bbKosong">
                            Berat Badan Kosong
                        </label>
                    </div>
                    <div class="form-check col">
                        <input class="form-check-input" type="checkbox" name="ktKosong" id="ktKosong" {{ request('ktKosong') == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ktKosong">
                            Kategori Tanding Kosong
                        </label>
                    </div>
                    <div class="form-check col">
                        <input class="form-check-input" type="checkbox" name="usiaKosong" id="usiaKosong" {{ request('usiaKosong') == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="usiaKosong">
                            Usia Kosong
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="namaPeserta">Nama Peserta</label>
                    <input type="text" class="form-control" name="nama_peserta"
                        value="{{ request('nama_peserta') ?? '' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" name="nik" value="{{ request('nik') ?? '' }}">
                </div>
                <div class="form-group col-md-6">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class='text-center bg-success text-white'>Total Peserta</th>
                                <th class='text-center bg-success text-white'>Sudah Bayar</th>
                                <th class='text-center bg-success text-white'>Sudah Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h3 text-center bg-success text-white">{{ $data->count() }}</td>
                                <td class="h3 text-center {{ $data->count() != $sudahBayar ? 'bg-danger' : '' }}">
                                    {{ $sudahBayar }}</td>
                                <td class="h3 text-center {{ $data->count() != $sudahValidasi ? 'bg-danger' : '' }}">
                                    {{ $sudahValidasi }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('kejuaraan.validasi') }}" class="btn btn-secondary">Reset</a>
            <button type="button" class="btn btn-warning" onclick="exportTableToPDF()">Export PDF</button>
        </form>

        <div class="col-12 d-flex justify-content-end">
            <button class="my-2 mx-3 btn btn-success" onclick="$('#tableForm').submit()">Validasi</button>
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
                        <th class="text-center">NIK</th>
                        <th class="text-center">Kategori Usia</th>
                        <th class="text-center">Kelas Sekolah</th>
                        <th class="text-center">Berat Badan</th>
                        <th class="text-center">Kategori Pertandingan</th>
                        <th class="text-center">Usia</th>
                        <th class="text-center">Validasi Bayar <br><input
                                {{ $data->count() == $sudahBayar && $data->count() != 0 ? 'checked' : '' }}
                                type="checkbox" name="sudah_bayar_all" value=""></th>
                        <th class="text-center">Validasi Data <br><input
                                {{ $data->count() == $sudahValidasi && $data->count() != 0 ? 'checked' : '' }}
                                type="checkbox" name="sudah_validasi_all" value=""></th>
                        <th class="text-center">Validator Bayar</th>
                        <th class="text-center">Validator Data</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    <form action="{{ route('kejuaraan.validasi.bayar') }}" method="POST" id="tableForm">
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
                                <td class="{{ $validateNik != '' ? 'bg-danger text-white' : '' }}">
                                    {{ $item->nik }}
                                    @if ($validateNik != '')
                                        <br><strong>{{ $validateNik }}</strong>
                                    @endif
                                </td>
                                <td>{{ $item->kategori_usia }}</td>
                                <td>{{ $item->kelas_sekolah }}</td>
                                <td class="{{ ($item->berat_badan=='' || $item->berat_badan==0) ? 'bg-danger text-white' : '' }}">{{ $item->berat_badan }}</td>
                                <td class="{{ ($item->weight->label ?? '') == '' ? 'bg-danger text-white' : '' }}">
                                    {{ $item->weight->label ?? '' }}</td>
                                <td class="{{ $item->usia == 0 ? 'bg-danger text-white' : '' }}">{{ $item->usia }}</td>
                                <td class="text-center">
                                    <input class="sudah_bayar" type="checkbox" name="sudah_bayar[{{ $item->id }}]"
                                        {{ $item->sudah_bayar == 'Y' ? 'checked' : '' }}>
                                    <input type="hidden" value="{{ $item->sudah_bayar }}" class="sudah_bayar_input"
                                        name="sudah_bayar[{{ $item->id }}]">
                                </td>
                                <td class="text-center">
                                    <input class="sudah_validasi" type="checkbox"
                                        {{ $item->sudah_validasi == 'Y' ? 'checked' : '' }}>
                                    <input type="hidden" value="{{ $item->sudah_validasi }}"
                                        class="sudah_validasi_input" name="sudah_validasi[{{ $item->id }}]">

                                </td>
                                <td>{{ $item->validator_bayar }}</td>
                                <td>{{ $item->validator }}</td>
                                <td>
                                    <button type="button" data-data="{{ json_encode($item) }}"
                                        onclick="detail_peserta(this)" class="btn btn-success btn-small">Edit</button>
                                    <button type="button" data-url="{{ route('kejuaraan.validasi.hapus', [$item->id]) }}"
                                        onclick="hapus_peserta(this)" class="btn btn-danger btn-small">Hapus</button>
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
