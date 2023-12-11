@extends('admin.index')
@section('title', 'List Komwil')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addKomwil">Tambah Komwil</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableKomwil">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Komwil</th>
                        <th>Alamat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataKomwil as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-komwil', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-komwil', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addKomwil" tabindex="-1" role="dialog" aria-labelledby="addKomwilLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKomwilLabel">Tambah Komwil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-komwil') }}" method="POST" id="formKomwil">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="nama">Alamat</label>
                                    <textarea id="address" name="address" class="form-control"></textarea>
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
        var form = $('#formKomwil')
        $('#tableKomwil').dataTable()
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data)
                if (typeof data.id !== 'undefined') {
                    $('#addKomwilLabel').text('Edit Komwil')
                    form.attr('action', '{{ route('update-komwil') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formKomwil');
                    $('input[name="name"]', form).val(data.name)
                    $('textarea[name="address"]', form).val(data.address)
                    $('#addKomwil').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
        function deleteData(e) {
            if(confirm('Hapus Komwil?')){
                $.get($(e).data('action'),function(){
                    location.reload()
                })
            }
        }
        $('.btn-add').click(function(){
            $('#addKomwilLabel').text('Tambah Komwil')
            form.attr('action', '{{ route('store-komwil') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
