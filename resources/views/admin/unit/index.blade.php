@extends('admin.index')
@section('title', 'List Unit')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addUnit">Tambah Unit</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableUnit">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Unit</th>
                        <th>Tingkat</th>
                        <th>Komwil</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataUnit as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->tingkat }}</td>
                            <td>{{ $item->data_komwil->name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-unit', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-unit', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="addUnitLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitLabel">Tambah Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-unit') }}" method="POST" id="formUnit">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
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
                                <div class="form-group">
                                    <label for="komwil">Komwil</label>
                                    <select name="komwil_id" class="form-control" id="komwil">
                                        <option value="">Pilih Komwil</option>
                                        @foreach ($komwil as $item)
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
        var form = $('#formUnit')
        $('#tableUnit').dataTable()
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addUnitLabel').text('Edit Unit')
                    form.attr('action', '{{ route('update-unit') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formUnit');
                    $('input[name="name"]', form).val(data.name)
                    $('select[name="tingkat"]',form).val(data.tingkat)
                    $('select[name="komwil_id"]',form).val(data.data_komwil.id)
                    $('#addUnit').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
        function deleteData(e) {
            if(confirm('Hapus Unit?')){
                $.get($(e).data('action'),function(){
                    location.reload()
                })
            }
        }
        $('.btn-add').click(function(){
            $('#addUnitLabel').text('Tambah Unit')
            form.attr('action', '{{ route('store-unit') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
