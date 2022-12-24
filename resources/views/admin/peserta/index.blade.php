@extends('admin.index')
@section('title', 'List Peserta')
@section('content')
<style>
    .buttons-excel,.buttons-pdf{
        display: none;
    }
</style>
    <div class="row d-flex justify-content-start mb-3">
        
    </div>
    <form action="{{route('peserta')}}">
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="komwil_id">Komwil</label>
                    <select name="komwil_id" class="form-control" id="komwil" data-href="{{ route('get-json-unit') }}">
                        <option value="">Pilih Komwil</option>
                        @foreach ($komwil as $item)
                            <option value="{{$item->id}}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="unit_id">Unit</label>
                    <select name="unit_id" class="form-control" id="unit_id" disabled>
                        <option value="">Pilih Unit</option>
                        {{-- @foreach ($unit as $item)
                            <option value="{{$item->id}}" {{(request('unit_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="ts_id">Tingkat Sabuk</label>
                    <select name="ts_id" class="form-control" id="ts_id">
                        <option value="">Pilih Sabuk</option>
                        @foreach ($ts as $item)
                            <option value="{{$item->id}}" {{(request('ts_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="no_peserta">Nomor Peserta</label>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="number" name="no_peserta_from" class="form-control" value="{{request('no_peserta_from')??''}}" placeholder="Nomor Peserta Mulai">
                        </div>
                        <div class="col-sm-6">
                            <input type="number" name="no_peserta_to" class="form-control" value="{{request('no_peserta_to')??''}}" placeholder="Nomor Peserta Sampai">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->role==='SPADM')
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="ts_id">Event</label>
                    @php($eventSelect = \App\Models\EventMaster::all())
                    <select name="event_id" class="form-control" data-src={{url()->current()}}>
                        <option value="">Pilih Event</option>
                        @foreach ($eventSelect as $item)
                        <option value="{{ $item->id }}" {{(request('event_id')??'')==$item->id?'selected':''}}>
                        {{ $item->name }} - {{ $item->lokasi }} -
                        {{ $item->penyelenggara }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="order_by">Order By</label>
                    <select name="order_by" class="form-control" id="">
                        <option value="name" {{(request('order_by')??'')=='name'?'selected':''}}>Nama</option>
                        <option value="komwil" {{(request('order_by')??'')=='komwil'?'selected':''}}>Komwil</option>
                        <option value="unit" {{(request('order_by')??'')=='unit'?'selected':''}}>Unit</option>
                    </select>
                </div>
            </div>
        </div>
        @endif
        <div class="row justify-content-start mb-2">
                <button type="submit" class="btn btn-info mr-2">Filter</button>
                <button type="button" class="btn btn-success btn-add mr-2" data-toggle="modal" data-target="#addPeserta">Tambah
                    Peserta</button>
                <button type="button" class="btn btn-primary mr-2 btn-cetak" data-src="{{route('cetak-kartu')}}">Cetak Kartu</button>
                <button class="btn btn-secondary mr-2" onclick="$('.buttons-excel').click()" tabindex="0" aria-controls="tablePeserta" type="button"><span>Excel</span></button>
                <button class="btn btn-secondary mr-2" onclick="$('.buttons-pdf').click()" tabindex="0" aria-controls="tablePeserta" type="button"><span>PDF</span></button>
        </div>
    </form>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped" id="tablePeserta">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><input type="checkbox" name="check_all" > </th>
                        <th>No. Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Komwil</th>
                        <th>Unit</th>
                        <th>TS</th>
                        <th>Tingkatan</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Aktif Event</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataPeserta as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><input type="checkbox" name="check_item" data-id="{{$item->id}}"></td>
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
                                <div style="width: 3cm; height:4cm; border:solid black;">
                                    <img src="/{{$item->foto}}" style="object-fit:contain" width="100%" height="100%" alt="">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-peserta', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#"
                                            data-action="{{ route('delete-peserta', $item->id) }}">Delete</a>
                                        <a class="dropdown-item" target="_blank" href="{{route('self-peserta',[Crypt::encrypt(json_encode( ['no_peserta'=>$item->no_peserta,'event_id'=>$item->event_id]))])}}">Cetak Kartu</a>
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
        $('#tablePeserta').dataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0, 2,3,4,5,6,7,8,9 ]
                    }
                },{
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0, 2,3,4,5,6,7,8,9 ]
                    }
                }
            ],
            columnDefs: [
                {
                    targets: [5],
                    orderData: [5,3],
                },
            ],
            
        })
        $(document).ready(function(){
            if($('#komwil').val()!=='') $('#komwil').change();
        })
        function editData(e) {
            $.get($(e).data('action'), function(data) {
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
                    $('input[name="foto"]', form).attr('required',false)
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
        }
        function deleteData(e) {
            if (confirm('Hapus User?')) {
                $.get($(e).data('action'), function() {
                    location.reload()
                })
            }
        }
        $('.btn-add').click(function() {
            $('#addPesertaLabel').text('Tambah Peserta')
            form.attr('action', '{{ route('store-peserta') }}')
            $('input[name="id"]').remove()
            $('.foto').hide()
            $('input[name="foto"]', form).attr('required',true)
            form.trigger("reset");
        })
        $("input[name='check_all']").click(function(){
            $("input[name='check_item']").not(this).prop('checked', this.checked);
        });
        $('.btn-cetak').click(function() {
            btn = $(this)
            id = $("input[name='check_item']:checked").map(function() {
                return $(this).data('id')
            }).get()
            window.location.href = btn.data('src')+'?id='+id.join(',')
            // $.ajax({
            //     url: btn.data('src'),
            //     data: {
            //         _token:$('input[name="_token"]').val(),
            //         id:id
            //     },
            //     method :'GET',
            //     success: function(d) {
            //         console.log(d.length)
            //         if(d.length > 0){
            //             var newWindow = window.open('/admin/peserta', "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
            //             newWindow.document.write(d);

            //         }
            //     }
            // })
        })
    </script>
@endsection
