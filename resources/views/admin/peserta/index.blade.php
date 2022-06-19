@extends('admin.index')
@section('title','List Peserta')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addPeserta">Tambah Peserta</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped" id="tablePeserta">
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
                        <td>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                    <a class="dropdown-item btn-edit" href="#"
                                        data-action="{{ route('json-peserta', $item->id) }}">Edit</a>
                                    <a class="dropdown-item btn-delete" href="#" data-action="{{ route('delete-peserta', $item->id) }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addPeserta" tabindex="-1" role="dialog" aria-labelledby="addPesertaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPesertaLabel">Tambah Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-peserta') }}" method="POST" id="formPeserta">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="ts_awal_id">Tingkat Sabuk</label>
                                    <select name="ts_awal_id" class="form-control" id="ts_awal_id">
                                        <option value="">Pilih Tingkat</option>
                                        @foreach ($ts as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="komwil">Komwil</label>
                                            <select name="komwil_id" class="form-control" id="komwil">
                                                <option value="">Pilih Komwil</option>
                                                @foreach ($komwil as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="unit_id">Unit</label>
                                            <select name="unit_id" class="form-control" id="unit_id">
                                                <option value="">Pilih Unit</option>
                                                @foreach ($unit as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tingkat">Tingkat</label>
                                    <select name="tingkat" class="form-control" id="tingkat">
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
                                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                                placeholder="Tempat Lahir" required>
                                            {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                                placeholder="Tanggal Lahir" required>
                                            {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                        </div>
                                    </div>
                                </div>                               
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var form = $('#formPeserta')
        $('#tablePeserta').dataTable()
        $('.btn-edit').click(function() {
            $.get($(this).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addPesertaLabel').text('Edit Peserta')
                    form.attr('action', '{{ route('update-peserta') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formPeserta');
                    $('input[name="name"]', form).val(data.name)
                    $('input[name="tempat_lahir"]', form).val(data.tempat_lahir)
                    $('input[name="tgl_lahir"]', form).val(data.tgl_lahir)
                    $('select[name="ts_awal_id"]',form).val(data.ts_awal_id)
                    $('select[name="komwil_id"]',form).val(data.data_komwil.id)
                    $('select[name="unit_id"]',form).val(data.unit_id)
                    $('select[name="tingkat"]',form).val(data.tingkat)
                    $('#addPeserta').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-delete').click(function(){
            if(confirm('Hapus Peserta?')){
                $.get($(this).data('action'),function(){
                    location.reload()
                })
            }
        })
        $('.btn-add').click(function(){
            $('#addPesertaLabel').text('Tambah Peserta')
            form.attr('action', '{{ route('store-peserta') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection