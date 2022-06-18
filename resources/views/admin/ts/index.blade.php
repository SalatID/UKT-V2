@extends('admin.index')
@section('title', 'List Ts')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addTs">Tambah Ts</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableTs">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Ts</th>
                        <th>TS Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataTs as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->ts_code }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item btn-edit" href="#"
                                            data-action="{{ route('json-ts', $item->id) }}">Edit</a>
                                        <a class="dropdown-item btn-delete" href="#" data-action="{{ route('delete-ts', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addTs" tabindex="-1" role="dialog" aria-labelledby="addTsLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTsLabel">Tambah Ts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-ts') }}" method="POST" id="formTs">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="tsCode">TS Code</label>
                                    <input type="text" class="form-control" name="ts_code" id="tsCode"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
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
        var form = $('#formTs')
        $('#tableTs').dataTable()
        $('.btn-edit').click(function() {
            $.get($(this).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addTsLabel').text('Edit Ts')
                    form.attr('action', '{{ route('update-ts') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formTs');
                    $('input[name="name"]', form).val(data.name)
                    $('input[name="ts_code"]', form).val(data.ts_code)
                    $('#addTs').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-delete').click(function(){
            if(confirm('Hapus Ts?')){
                $.get($(this).data('action'),function(){
                    location.reload()
                })
            }
        })
        $('.btn-add').click(function(){
            $('#addTsLabel').text('Tambah Ts')
            form.attr('action', '{{ route('store-ts') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
