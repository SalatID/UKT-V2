@extends('guest.index')

@section('content')
    
<form action="{{route('proc-kelompok')}}" method="POST">
    @csrf
    <input type="hidden" name="event_id" value="{{$event_id}}">
    <input type="hidden" name="alias" value="{{$alias}}">
    <div class="row">
        <div class="col-xl-12 mb-3">
            <select name="penilai_id" class="form-control" required>
                <option value="">--Pilih Penguji--</option>
                @foreach ($penilai as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-12 mb-3">
            <select name="kelompok_id" class="form-control" required>
                <option value="">--Pilih Kelompok--</option>
                @foreach ($kelompok as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-12">
            <button class="btn btn-success w-100">Simpan</button>
        </div>
    </div>
</form>
@endsection