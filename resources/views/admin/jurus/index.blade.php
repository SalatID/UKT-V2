@extends('admin.index')
@section('title', 'List Jurus')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addJurus">Tambah Jurus</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableJurus">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Jurus</th>
                        <th>TS</th>
                        <th>Parent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataJurus as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->data_ts->name }}</td>
                            <td>{{ $item->data_parent->name??'' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-jurus', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-jurus', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addJurus" tabindex="-1" role="dialog" aria-labelledby="addJurusLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJurusLabel">Tambah Jurus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-jurus') }}" method="POST" id="formJurus">
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
                                    <label for="parent">Parent</label>
                                    <select name="parent_id" class="form-control" id="parent">
                                        <option value="">Pilih Parent</option>
                                        <option value="0">Tidak Ada Parent</option>
                                        @foreach ($parent as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
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
        var form = $('#formJurus')
        $('#tableJurus').dataTable({
            paging:false
        })
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data.data_parent===null)
                if (typeof data.id !== 'undefined') {
                    $('#addJurusLabel').text('Edit Jurus')
                    form.attr('action', '{{ route('update-jurus') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formJurus');
                    $('input[name="name"]', form).val(data.name)
                    $('select[name="ts_id"]',form).val(data.ts_id)
                    $('select[name="parent_id"]',form).val((data.data_parent===null?0:data.data_parent.id))
                    $('#addJurus').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
        function deleteData(e) {
            if(confirm('Hapus Jurus?')){
                $.get($(e).data('action'),function(){
                    location.reload()
                })
            }
        }
        $('.btn-add').click(function(){
            $('#addJurusLabel').text('Tambah Jurus')
            form.attr('action', '{{ route('store-jurus') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
