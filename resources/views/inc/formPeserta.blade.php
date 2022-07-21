<form action="{{ route('store-peserta') }}" method="POST" id="formPeserta" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" required name="name" id="nama" placeholder="Nama" required>
        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
    </div>
    <div class="form-group">
        <label for="ts_awal_id">Tingkat Sabuk</label>
        <select name="ts_awal_id" class="form-control" required id="ts_awal_id">
            <option value="">Pilih Tingkat</option>
            @foreach ($ts as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="form-group">
                <label for="komwil">Komwil</label>
                <select name="komwil_id" class="form-control" required id="komwil"
                    data-href="{{ route('get-json-unit') }}">
                    <option value="">Pilih Komwil</option>
                    @foreach ($komwil as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" class="form-control" required disabled id="unit_id">
                    <option value="">Pilih Unit</option>

                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="tingkat">Tingkat</label>
        <select name="tingkat" class="form-control" required id="tingkat">
            <option value="">Pilih Tingkat</option>
            <option value="TK">TK</option>
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
            <option value="SMA/SMK">SMA/SMK</option>
            <option value="Kuliah">Kuliah</option>
            <option value="Bekerja">Bekerja</option>
        </select>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" class="form-control" required name="tempat_lahir" id="tempat_lahir"
                    placeholder="Tempat Lahir" required>
                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" required name="tgl_lahir" id="tgl_lahir"
                    placeholder="Tanggal Lahir" required>
                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div>
        </div>
    </div>
    @if ((auth()->user()->role ?? 'SPADM') == 'SPADM')
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select name="event_id" class="form-control" required id="event_id" readonly>
                        @if(is_a($event, 'Illuminate\Database\Eloquent\Collection'))
                            @foreach($event as $item)
                            <option value="{{ $item->id }}" selected>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                            @endforeach
                        @else 

                        <option value="{{ $event->id }}" selected>
                            {{ $event->name }} - {{ $event->lokasi }} -
                            {{ $event->penyelenggara }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    @endif
    <div class="form-group">
        <label for="foto">Foto 3x4</label>
        <input type="file" class="form-control" required name="foto" id="foto" placeholder="Foto 3x4">
        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
    </div>
    <div class="row foto">
        <div class="col-6">
            <strong class="text-center">Foto Anda</strong>
            <br>
            <img src="" class="img-fluid foto" id="prev-foto" width="192cm" height="256cm" alt="Event Banner">

        </div>
        <div class="col-6">
            <strong class="text-center">Sample Foto</strong>
            <br>
            <img src="/assets/img/3x4.jpg" width="192cm" height="256cm" class="img-fluid" alt="Event Banner">
        </div>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
