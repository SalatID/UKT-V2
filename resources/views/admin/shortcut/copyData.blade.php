@extends('admin.index')
@section('title', 'Shortcut')
@section('content')
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            <h3 class="card-title">Jurus</h3>
        </div>
        <div class="card-body">
            <form action="{{route('copy-jurus')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_sumber">Sumber</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_sumber" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_sumber')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_tujuan">Tujuan</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_tujuan" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_tujuan')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Copy</button>
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
            <form action="{{route('copy-peserta')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_sumber">Sumber</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_sumber" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_sumber')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_tujuan">Tujuan</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_tujuan" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_tujuan')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Copy</button>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            <h3 class="card-title">Penilai</h3>
        </div>
        <div class="card-body">
            <form action="{{route('copy-penilai')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_sumber">Sumber</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_sumber" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_sumber')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_tujuan">Tujuan</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select name="event_tujuan" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_tujuan')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Copy</button>
            </form>
        </div>
    </div>
</div>
<script>
    $('select[name="event_sumber"]').change(function(){
        $('select[name="event_tujuan"]').find('option[value="'+$(this).val()+'"]').attr('disabled',true)
    })
</script>
@endsection
