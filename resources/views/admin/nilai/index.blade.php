@extends('admin.index')
@section('title', 'List Nilai')
@section('content')
    {{-- <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addNilai">Tambah
            Nilai</button>
    </div> --}}
    @php
        $allow = [
            'SPADM','KOMDA'
        ];
    @endphp
    <form action="{{route('nilai')}}">
        @csrf
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="kelompok_id">Kelompok</label>
                    <select name="kelompok_id" class="form-control" id="kelompok_id">
                        <option value="">Pilih Kelompok</option>
                        @foreach ($kelompok as $item)
                            <option value="{{$item->id}}" {{(request('kelompok_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="ts_id">Tingkat Sabuk</label>
                    <select name="ts_id" class="form-control" id="ts_id">
                        <option value="">Pilih Sabuk</option>
                        @foreach ($ts as $item)
                            <option value="{{$item->id}}" {{(request('ts_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="penguji_id">Penilai</label>
                    <select name="penguji_id" class="form-control" id="penguji_id">
                        <option value="">Pilih Penilai</option>
                        @foreach ($penilai as $item)
                            <option value="{{$item->id}}" {{(request('penguji_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="jurus_id">Jurus</label>
                    <select name="jurus_id" class="form-control" id="jurus_id">
                        <option value="">Pilih Jurus</option>
                        @foreach ($jurus as $item)
                            <option value="{{$item->id}}" {{(request('jurus_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped" id="tableNilai">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Tingkatan Sabuk</th>
                        <th>Unit</th>
                        <th>Komwil</th>
                        <th>Kelompok</th>
                        <th>Event</th>
                        <th>Penguji</th>
                        <th>Jurus</th>
                        <th>Nilai</th>
                        @if(in_array(auth()->user()->role,$allow))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataNilai as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->data_peserta->name }}</td>
                            <td>{{ $item->data_peserta->data_ts->name }}</td>
                            <td>{{ $item->data_peserta->data_unit->name }}</td>
                            <td>{{ $item->data_peserta->data_komwil->name }}</td>
                            <td>{{ $item->data_kelompok->name??'' }}</td>
                            <td>{{ $item->data_event->name }}</td>
                            <td>{{ $item->data_penilai->name }}</td>
                            <td>{{ $item->data_jurus->name }}</td>
                            <td>{{ $item->nilai }}</td>
                            @if(in_array(auth()->user()->role,$allow))
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item btn-edit" href="#"
                                            data-action="{{ route('json-peserta', $item->id) }}">Edit</a>
                                        <a class="dropdown-item btn-delete" href="#"
                                            data-action="{{ route('delete-peserta', $item->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $('#tableNilai').dataTable()
    </script>
@endsection
