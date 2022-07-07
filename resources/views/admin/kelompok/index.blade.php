@extends('admin.index')
@section('title', 'List Kelompok')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <a href="{{route('add-kelompok')}}" class="btn btn-success" >Tambah Kelompok</a>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableKelompok">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelompok</th>
                        <th>TS</th>
                        <th>Anggota</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataKelompok as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->data_ts->name }}</td>
                            <td>
                                <ol>
                                    @foreach ($item->data_peserta as $p)
                                        <li>{{$p->name}}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item btn-edit" href="{{route('edit-kelompok',$item->id)}}">Edit</a>
                                        <a class="dropdown-item btn-delete" href="#" data-action="{{ route('delete-kelompok', $item->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   
    <script>
        var form = $('#formKelompok')
        $('#tableKelompok').dataTable()
        $('.btn-edit').click(function() {
            $.get($(this).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addKelompokLabel').text('Edit Kelompok')
                    form.attr('action', '{{ route('update-kelompok') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formKelompok');
                    $('input[name="name"]', form).val(data.name)
                    $('select[name="ts_id"]',form).val(data.ts_id)
                    $('select[name="komwil_id"]',form).val(data.data_komwil.id)
                    $('#addKelompok').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        });
        $('.btn-delete').click(function(){
            if(confirm('Hapus Kelompok?')){
                $.get($(this).data('action'),function(){
                    location.reload()
                })
            }
        })
        $('.btn-add').click(function(){
            $('#addKelompokLabel').text('Tambah Kelompok')
            form.attr('action', '{{ route('store-kelompok') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
    </script>
@endsection
