@extends('admin.index')
@section('title', 'List Nilai')
@section('content')
    {{-- <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addNilai">Tambah
            Nilai</button>
    </div> --}}
    @php
        $allow = [
            'SPADM','KOMDA'
        ];
    @endphp
    <form action="{{route('nilai')}}">
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="kelompok_id">Kelompok</label>
                    <select name="kelompok_id" class="form-control" id="kelompok_id">
                        <option value="">Pilih Kelompok</option>
                        @foreach ($kelompok as $item)
                            <option value="{{$item->id}}" {{(request('kelompok_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
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
                    <label for="penguji_id">Penilai</label>
                    <select name="penguji_id" class="form-control" id="penguji_id">
                        <option value="">Pilih Penilai</option>
                        @foreach ($penilai as $item)
                            <option value="{{$item->id}}" {{(request('penguji_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="jurus_id">Jurus</label>
                    <select name="jurus_id" class="form-control" id="jurus_id">
                        <option value="">Pilih Jurus</option>
                        @foreach ($jurus as $item)
                            <option value="{{$item->id}}" {{(request('jurus_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
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
        </div>
        @endif
        <div class="row">
            <div class="col-xl-4">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped" id="tableNilai">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Tingkatan Sabuk</th>
                        <th>Unit</th>
                        <th>Komwil</th>
                        <th>Kelompok</th>
                        <th>Event</th>
                        <th>Penguji</th>
                        <th>Jurus</th>
                        <th>Nilai</th>
                        @if(in_array(auth()->user()->role,$allow))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataNilai as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->data_peserta->no_peserta??'' }}</td>
                            <td>{{ $item->data_peserta->name??'' }}</td>
                            <td>{{ $item->data_peserta->data_ts->name??'' }}</td>
                            <td>{{ $item->data_peserta->data_unit->name??'' }}</td>
                            <td>{{ $item->data_peserta->data_komwil->name??'' }}</td>
                            <td>{{ $item->data_kelompok->name??'' }}</td>
                            <td>{{ $item->data_event->name??'' }}</td>
                            <td>{{ $item->data_penilai->name??'' }}</td>
                            <td>{{ $item->data_jurus->name??'' }}</td>
                            <td>{{ $item->nilai }}</td>
                            @if(in_array(auth()->user()->role,$allow))
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="#"
                                            data-action="{{ route('json-nilai', $item->id) }}">Edit</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#"
                                            data-action="{{ route('delete-nilai', $item->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="editNilai" tabindex="-1" role="dialog" aria-labelledby="editNilaiLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="editNilaiLabel">Tambah Unit</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-xl-12">
                         <form action="{{ route('store-unit') }}" method="POST" id="formNilai">
                             @csrf
                             <div class="form-group">
                                 <label for="nama">Nama</label>
                                 <input type="text" class="form-control" name="name" id="nama"
                                     placeholder="Nama" disabled>
                                 {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                             </div>
                             <div class="form-group">
                                <label for="ts_awal_id">Tingkat Sabuk Awal</label>
                                <select name="ts_awal_id" class="form-control" required id="ts_awal_id" disabled>
                                    <option value="">Pilih Tingkat</option>
                                    @foreach (\App\Models\Ts::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ts_akhir_id">Tingkat Sabuk Akhir</label>
                                <select name="ts_akhir_id" class="form-control" required id="ts_akhir_id">
                                    <option value="">Pilih Tingkat</option>
                                    @foreach (\App\Models\Ts::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penguji_id">Penguji</label>
                                <select name="penguji_id" class="form-control" required id="penguji_id">
                                    <option value="">Pilih Tingkat</option>
                                    @foreach (\App\Models\Penilai::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penguji_id">Nilai</label>
                                <input type="number" name="nilai" class="form-control">
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
        var form = $('#formNilai')
        $('#tableNilai').dataTable()
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#editNilaiLabel').text('Edit Nilai')
                    form.attr('action', '{{ route('update-nilai') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formNilai');
                    $('input[name="name"]', form).val(data.data_peserta.name)
                    $('select[name="ts_awal_id"]',form).val(data.data_peserta.ts_awal_id)
                    $('select[name="ts_akhir_id"]',form).val(data.data_peserta.ts_akhir_id)
                    $('select[name="penguji_id"]',form).val(data.penguji_id)
                    $('input[name="nilai"]',form).val(data.nilai)
                    $('#editNilai').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
    </script>
@endsection
