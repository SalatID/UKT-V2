@extends('admin.index')
@section('title','List Peserta')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success">Tambah Peserta</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Komwil</th>
                        <th>Unit</th>
                        <th>TS</th>
                        <th>Tingkatan</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no=1)
                    @foreach ($dataPeserta as $item)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$item->no_peserta}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->data_komwil->name}}</td>
                        <td>{{$item->data_unit->name}}</td>
                        <td>{{$item->data_ts->name}}</td>
                        <td>{{$item->tingkat}}</td>
                        <td>{{$item->tempat_lahir}}</td>
                        <td>{{$item->tgl_lahir}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection