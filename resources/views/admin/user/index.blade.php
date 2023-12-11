@extends('admin.index')
@section('title', 'List User')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addUser">Tambah User</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableUser">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Unit</th>
                        <th>Komwil</th>
                        <th>Aktif Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataUser as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->data_unit->name??'' }}</td>
                            <td>{{ $item->data_unit->data_komwil->name??'' }}</td>
                            <td>{{ $item->data_event->name??'' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item btn-edit" href="#"
                                            data-action="{{ route('json-user', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-user', $item->id) }}">Delete</a>
                                        <a class="dropdown-item" onclick="updatePassword(this)" href="#"
                                            data-id="{{ $item->id }}">Ganti Password</a>
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
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-user') }}" method="POST" id="formUser">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Email" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="number" class="form-control" name="phone" id="phone"
                                        placeholder="Phone">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="komwil">Komwil</label>
                                            <select name="komwil_id" class="form-control" id="komwil" data-href="{{route('get-json-unit')}}">
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
                                            <select name="unit_id" class="form-control" disabled id="unit_id">
                                                <option value="">Pilih Unit</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 validasi_email">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="validasi_email" id="validasiEmail">
                                        <label class="form-check-label" for="validasiEmail">Validasi Email</label>
                                    </div>
                                </div>
                                <div class="row row_password">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="retype_password">Retype Password</label>
                                            <input type="password" class="form-control" name="retype_password" id="retype_password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Role</label>
                                    <select name="role" class="form-control" id="role">
                                        <option value="">Pilih Role</option>
                                       <option value="PUSER">Public User</option>
                                       <option value="KOMDA">Pengurus Komda</option>
                                       <option value="KOMWL">Pengurus Komwil</option>
                                       <option value="PJUNT">Penanggung Jawab Unit</option>
                                       <option value="SPADM">Super Admin</option>
                                    </select>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="event_id">Aktif Event</label>
                                    <select name="event_id" class="form-control" id="event_id">
                                        <option value="">Pilih Event</option>
                                       @foreach ($event as $item)
                                        <option value="{{$item->id}}">{{$item->name}} - {{$item->lokasi}} - {{$item->penyelenggara}}</option>
                                       @endforeach
                                    </select>
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
    <div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="updatePasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordLabel">Update Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('update-password') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="retype_password">Retype Password</label>
                                    <input type="password" class="form-control" name="retype_password" id="retype_password"
                                        placeholder="Retype Password" required>
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
        var form = $('#formUser')
        $('#tableUser').dataTable()
        $('input[name="validasi_email"]').change(function(){
            if($(this).prop('checked')){
                $('.row_password').slideUp()
            } else {
                $('.row_password').slideDown()
            }
        })
        $('.btn-edit').click(function() {
            $.get($(this).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addUserLabel').text('Edit User')
                    form.attr('action', '{{ route('update-user') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formUser');
                    $('input[name="name"]', form).val(data.name)
                    $('input[name="email"]', form).val(data.email)
                    $('input[name="phone"]', form).val(data.phone)
                    $('select[name="komwil_id"]',form).val(data.data_unit.komwil_id)
                    $('select[name="komwil_id"]',form).attr('data-unit_id',data.data_unit.id)
                    $('select[name="komwil_id"]',form).change()
                    $('select[name="unit_id"]',form).val(data.unit_id)
                    $('select[name="role"]',form).val(data.role)
                    $('.row_password').hide()
                    $('.validasi_email').hide()
                    $('#addUser').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-add').click(function(){
            $('#addUserLabel').text('Tambah User')
            form.attr('action', '{{ route('store-user') }}')
            $('input[name="id"]').remove()
            $('.row_password').show()
            $('.validasi_email').show()
            form.trigger("reset");
        })
        $('.btn-delete').click(function(){
            if(confirm('Hapus Peserta?')){
                $.get($(this).data('action'),function(){
                    location.reload()
                })
            }
        })
        function updatePassword(e)
        {
            $('input[name="user_id"]',$('#updatePassword')).val($(e).data('id'))
            $('#updatePassword').modal('show')
        }
    </script>
@endsection
