@extends('admin.index')
@section('title', 'List Event')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addEvent">Tambah Event</button>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableEvent">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Lokasi</th>
                        <th>Komwil</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataEvent as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->penyelenggara }}</td>
                            <td>{{ date('Y-m-d',strtotime($item->tgl_mulai))}}</td>
                            <td>{{ date('Y-m-d',strtotime($item->tgl_selesai))}}</td>
                            <td>{{ $item->lokasi}}</td>
                            <td>{{ $item->data_komwil->name??''}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item btn-edit" href="#"
                                            data-action="{{ route('json-event', $item->id) }}">Edit</a>
                                        <a class="dropdown-item btn-delete" href="#" data-action="{{ route('delete-event', $item->id) }}">Delete</a>
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
    <div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="addEventLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventLabel">Tambah Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('store-event') }}" method="POST" id="formEvent"  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="name" id="nama"
                                        placeholder="Nama" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="penyelenggara">Penyelenggara</label>
                                    <input type="text" class="form-control" name="penyelenggara" id="penyelenggara"
                                        placeholder="Penyelenggara" required>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi" id="lokasi"
                                        placeholder="Lokasi">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="tgl_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="tgl_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="komwil_id">Komwil</label>
                                    <select name="komwil_id" class="form-control" id="komwil_id">
                                        <option value="">Pilih Komwil</option>
                                       @foreach ($dataKomwil as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Banner Event</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar"
                                        placeholder="Banner Event">
                                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                </div>
                                <div class="row gambar">
                                    <div class="col-12">
                                        <img src="" class="img-fluid gambar" alt="Event Banner">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var form = $('#formEvent')
        $('#tableEvent').dataTable()
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
                    $('#addEventLabel').text('Edit Event')
                    form.attr('action', '{{ route('update-event') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formEvent');
                    $('input[name="name"]', form).val(data.name)
                    $('input[name="penyelenggara"]', form).val(data.penyelenggara)
                    $('input[name="lokasi"]', form).val(data.lokasi)
                    $('input[name="tgl_mulai"]', form).val(formatDate(data.tgl_mulai,'-'))
                    $('input[name="tgl_selesai"]', form).val(formatDate(data.tgl_selesai,'-'))
                    $('select[name="komwil_id"]',form).val(data.komwil_id)
                    $('.gambar').show()
                    $('.gambar').attr('src','/'+data.gambar)
                    $('#addEvent').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-add').click(function(){
            $('#addEventLabel').text('Tambah Event')
            form.attr('action', '{{ route('store-event') }}')
            $('input[name="id"]').remove()
            $('.row_password').show()
            $('.validasi_email').show()
            $('.gambar').hide()
            form.trigger("reset");
        })
        $('.btn-delete').click(function(){
            if(confirm('Hapus Event?')){
                $.get($(this).data('action'),function(){
                    location.reload()
                })
            }
        })
    </script>
@endsection
