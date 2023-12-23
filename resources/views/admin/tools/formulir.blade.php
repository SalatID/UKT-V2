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
                            <select data-src="{{url()->current()}}" name="event_id" class="form-control" required>
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
                            @php($kelompok = \App\Models\Kelompok::whereNull('deleted_at')->where(['event_id'=>request('event_id')??''])->get())
                            <select name="kelompok_id" class="form-control">
                                <option value="">Semua Kelompok</option>
                                @foreach ($kelompok as $item)
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="event_id">Event</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select data-src="{{url()->current()}}" name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="komwil_id">Komwil</label>
                            <select name="komwil_id" class="form-control" id="komwil" data-href="{{ route('get-json-unit') }}">
                                <option value="">Pilih Komwil</option>
                                @foreach (\App\Models\Komwil::all() as $item)
                                    <option value="{{$item->id}}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select name="unit_id" class="form-control" id="unit_id" disabled>
                                <option value="">Pilih Unit</option>
                                {{-- @foreach ($unit as $item)
                                    <option value="{{$item->id}}" {{(request('unit_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="order_by">No Peserta</label>
                                    <input type="text" class="form-control" name="no_peserta" value="{{request('no_peserta')??''}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="1" {{request('innot')==1?'checked':''}} {{request('innot')==null?'checked':''}}>
                                    <label class="form-check-label">In</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="0" {{request('innot')==='0'?'checked':''}} >
                                    <label class="form-check-label">Not In</label>
                                </div>
                            </div>
        
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
            <h3 class="card-title">Peserta Final</h3>
        </div>
        <div class="card-body">
            <form action="{{route('absensi-peserta')}}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="type" value="final" id="">
                <input type="hidden" name="view" value="admin.tools.formulir.peserta">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="event_id">Event</label>
                            @php($eventSelect = \App\Models\EventMaster::all())
                            <select data-src="{{url()->current()}}" name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="komwil_id">Komwil</label>
                            <select name="komwil_id" class="form-control" id="komwil" data-href="{{ route('get-json-unit') }}">
                                <option value="">Pilih Komwil</option>
                                @foreach (\App\Models\Komwil::all() as $item)
                                    <option value="{{$item->id}}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select name="unit_id" class="form-control" id="unit_id" disabled>
                                <option value="">Pilih Unit</option>
                                {{-- @foreach ($unit as $item)
                                    <option value="{{$item->id}}" {{(request('unit_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="order_by">No Peserta</label>
                                    <input type="text" class="form-control" name="no_peserta" value="{{request('no_peserta')??''}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="1" {{request('innot')==1?'checked':''}} {{request('innot')==null?'checked':''}}>
                                    <label class="form-check-label">In</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="0" {{request('innot')==='0'?'checked':''}} >
                                    <label class="form-check-label">Not In</label>
                                </div>
                            </div>
        
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
                            <select data-src="{{url()->current()}}" name="event_id" class="form-control" required>
                                <option value="">Pilih Event</option>
                                @foreach ($eventSelect as $item)
                                <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                                {{ $item->name }} - {{ $item->lokasi }} -
                                {{ $item->penyelenggara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="komwil_id">Komwil</label>
                            <select name="komwil_id" class="form-control" id="komwil" data-href="{{ route('get-json-unit') }}">
                                <option value="">Pilih Komwil</option>
                                @foreach (\App\Models\Komwil::all() as $item)
                                    <option value="{{$item->id}}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select name="unit_id" class="form-control" id="unit_id" disabled>
                                <option value="">Pilih Unit</option>
                                {{-- @foreach ($unit as $item)
                                    <option value="{{$item->id}}" {{(request('unit_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="order_by">No Peserta</label>
                                    <input type="text" class="form-control" name="no_peserta" value="{{request('no_peserta')??''}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="1" {{request('innot')==1?'checked':''}} {{request('innot')==null?'checked':''}}>
                                    <label class="form-check-label">In</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="innot" value="0" {{request('innot')==='0'?'checked':''}} >
                                    <label class="form-check-label">Not In</label>
                                </div>
                            </div>
        
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
<script>
    $('select[name="event_id"]').change(function(){
        if($(this).val()=='') {
        window.location.href = $(this).data('src')
        return
      }
      window.location.href =$(this).data('src')+'?event_id='+$(this).val()
    })
</script>
@endsection