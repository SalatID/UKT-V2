@extends('admin.index')
@section('title', 'Cetak Sertifikat')
@section('content')
    <form action="{{ route('preview-sertifikat') }}">
        @csrf
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select name="event_id" class="form-control" data-href="{{ route('get-json-unit') }}" required>
                        <option value="">Pilih Event</option>
                        @foreach ($event as $item)
                            <option value="{{ $item->id }}" {{ (request('event_id') ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="no_peserta">Nomor Peserta</label>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="number" name="no_peserta_from" class="form-control"
                                value="{{ request('no_peserta_from') ?? '' }}" placeholder="Nomor Peserta Mulai">
                        </div>
                        <div class="col-sm-6">
                            <input type="number" name="no_peserta_to" class="form-control"
                                value="{{ request('no_peserta_to') ?? '' }}" placeholder="Nomor Peserta Sampai">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-start mb-2">
            <div class="form-check mx-1">
                <input class="form-check-input" type="checkbox" name="blangko" id="blangko">
                <label class="form-check-label" for="blangko">Blangko</label>
            </div>
            <div class="form-check mx-1">
                <input class="form-check-input" type="radio" name="muka" value="depan" id="muka_depan" checked>
                <label class="form-check-label" for="muka_depan">Depan</label>
            </div>
            <div class="form-check mx-1">
                <input class="form-check-input" type="radio" name="muka" value="belakang" id="muka_belakang">
                <label class="form-check-label" for="muka_belakang">Belakang</label>
            </div>
            <div class="form-check mx-1">
                <input class="form-check-input" type="checkbox" name="foto" id="foto">
                <label class="form-check-label" for="foto">Foto</label>
            </div>
            <div class="form-check mx-1">
                <input class="form-check-input" type="checkbox" name="data" id="data" checked>
                <label class="form-check-label" for="data">Data</label>
            </div>
        </div>
        <div class="row justify-content-start mb-2">
            <button type="submit" class="btn btn-primary mr-2 btn-cetak" data-src="{{ route('cetak-kartu') }}">Cetak
                Sertifikat</button>
        </div>
    </form>
@endsection