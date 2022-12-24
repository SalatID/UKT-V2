@extends('admin.index')
@section('title', 'Form Manual')
@section('content')
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            <h3 class="card-title">Penilaian Manual</h3>
        </div>
        <div class="card-body">
            <form action="{{route('penilaian-manual')}}" method="POST" target="_blank">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_id">Event</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelompok_id">Kelompok</label>
                            @php($eventSelect = \App\Models\Kelompok::all())
                            <select name="kelompok_id" class="form-control">
                                <option value="">Semua Kelompok</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('kelompok_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Cetak</button>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            <h3 class="card-title">Peserta</h3>
        </div>
        <div class="card-body">
            <form action="{{route('absensi-peserta')}}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="view" value="admin.tools.formulir.peserta">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_id">Event</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="komwil_id">Komwil</label>
                            @php($eventSelect = \App\Models\Komwil::all())
                            <select name="komwil_id" class="form-control">
                                <option value="">Semua Komwil</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Cetak</button>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            <h3 class="card-title">Absen</h3>
        </div>
        <div class="card-body">
            <form action="{{route('absensi-peserta')}}" method="POST" target="_blank">
                <input type="hidden" name="view" value="admin.tools.formulir.absen">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="event_id">Event</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="komwil_id">Komwil</label>
                            @php($eventSelect = \App\Models\Komwil::all())
                            <select name="komwil_id" class="form-control">
                                <option value="">Semua Komwil</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="komwil_id">Limit</label>
                            <input type="number" name="limit" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Cetak</button>
            </form>
        </div>
    </div>
</div>
@endsection
