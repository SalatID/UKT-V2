@extends('admin.index')
@section('title', 'List Peserta')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addPeserta">Tambah
            Peserta</button>
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
                        <th>Aktif Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataPeserta as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->no_peserta }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->data_komwil->name }}</td>
                            <td>{{ $item->data_unit->name }}</td>
                            <td>{{ $item->data_ts->name }}</td>
                            <td>{{ $item->tingkat }}</td>
                            <td>{{ $item->tempat_lahir }}</td>
                            <td>{{ $item->tgl_lahir }}</td>
                            <td>{{ $item->data_event->name ?? 'No Event' }} -
                                {{ $item->data_event->penyelenggara ?? 'No Event' }}</td>
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
                            @include('inc.formPeserta')
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
                        value: data.id
                    }).appendTo('#formPeserta');
                    $('input[name="name"]', form).val(data.name)
                    $('input[name="tempat_lahir"]', form).val(data.tempat_lahir)
                    $('input[name="tgl_lahir"]', form).val(data.tgl_lahir)
                    $('select[name="ts_awal_id"]', form).val(data.ts_awal_id)
                    $('select[name="komwil_id"]', form).val(data.komwil_id)
                    $('select[name="komwil_id"]', form).attr('data-unit_id', data.unit_id)
                    $('select[name="komwil_id"]', form).change()
                    $('select[name="unit_id"]', form).val(data.unit_id)
                    $('select[name="tingkat"]', form).val(data.tingkat)
                    $('select[name="event_id"]', form).val(data.event_id)
                    $('.foto').show()
                    $('.foto').attr('src', '/' + data.foto)
                    $('#addPeserta').modal('show')
                    return
                }
                showAllerJs({
                    error: true,
                    message: 'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-delete').click(function() {
            if (confirm('Hapus User?')) {
                $.get($(this).data('action'), function() {
                    location.reload()
                })
            }
        })
        $('.btn-add').click(function() {
            $('#addPesertaLabel').text('Tambah Peserta')
            form.attr('action', '{{ route('store-peserta') }}')
            $('input[name="id"]').remove()
            $('.foto').hide()
            form.trigger("reset");
        })
    </script>
@endsection
