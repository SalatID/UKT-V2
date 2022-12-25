@extends('admin.index')
@section('title', 'List Penilai')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addPenilai">Tambah Penilai</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tablePenilai">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Penilai</th>
                        {{-- <th>TS</th> --}}
                        {{-- <th>Komwil</th> --}}
                        <th>Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataPenilai as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            {{-- <td>{{ $item->data_ts->name }}</td> --}}
                            {{-- <td>{{ $item->data_komwil->name??'' }}</td> --}}
                            <td>{{ $item->data_event->name??'' }}, {{ $item->data_event->lokasi??'' }} {{ $item->data_event->penyelenggara??'' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-penilai', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-penilai', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addPenilai" tabindex="-1" role="dialog" aria-labelledby="addPenilaiLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenilaiLabel">Tambah Penilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-penilai') }}" method="POST" id="formPenilai">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="ts_id">Tingkat Sabuk</label>
                                    <select name="ts_id" class="form-control" id="ts_id">
                                        <option value="">Pilih Tingkat</option>
                                        @foreach ($ts as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="komwil">Komwil</label>
                                    <select name="komwil_id" class="form-control" id="komwil">
                                        <option value="">Pilih Komwil</option>
                                        @foreach ($komwil as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if (auth()->user()->role === 'SPADM')
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label for="event_id">Event</label>
                                                <select name="event_id" class="form-control" id="event_id">
                                                    <option value="">Pilih Event</option>
                                                    @foreach ($event as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ (session()->get(auth()->user()->id . '_' . 'form_data')['event_id'] ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }} - {{ $item->lokasi }} -
                                                            {{ $item->penyelenggara }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var form = $('#formPenilai')
        $('#tablePenilai').dataTable()
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addPenilaiLabel').text('Edit Penilai')
                    form.attr('action', '{{ route('update-penilai') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formPenilai');
                    $('input[name="name"]', form).val(data.name)
                    $('select[name="ts_id"]',form).val(data.ts_id)
                    $('select[name="event_id"]',form).val(data.event_id)
                    $('select[name="komwil_id"]',form).val(data.komwil_id)
                    $('#addPenilai').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
        function deleteData(e) {
            if(confirm('Hapus Penilai?')){
                $.get($(e).data('action'),function(){
                    location.reload()
                })
            }
        }
        $('.btn-add').click(function(){
            $('#addPenilaiLabel').text('Tambah Penilai')
            form.attr('action', '{{ route('store-penilai') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
