@extends('admin.index')
@section('title', 'Cetak Sertifikat')
@section('content')
<form action="{{ route('preview-sertifikat') }}" target="_blank">
    @include('inc.formNilai')
    
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
