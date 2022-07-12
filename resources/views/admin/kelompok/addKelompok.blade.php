@extends('admin.index')
@section('title','Tambah Kelompok')
@section('content')
<form action="{{route('store-kelompok')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xl-6">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="name" id="nama" value="{{session()->get(auth()->user()->id.'_'.'form_data')['name']??''}}"
                    placeholder="Nama" required>
                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label for="ts_id">Tingkat Sabuk</label>
                <select name="ts_id" class="form-control" id="ts_id">
                    <option value="">Pilih Tingkat</option>
                    @foreach ($ts as $item)
                        <option value="{{$item->id}}" {{(session()->get(auth()->user()->id.'_'.'form_data')['ts_id']??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if (auth()->user()->role==='SPADM')
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select name="event_id" class="form-control" id="event_id">
                        <option value="">Pilih Event</option>
                        @foreach ($event as $item)
                            <option value="{{$item->id}}" {{(session()->get(auth()->user()->id.'_'.'form_data')['event_id']??'')==$item->id?'selected':''}}>{{$item->name}} - {{$item->lokasi}} - {{$item->penyelenggara}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-12">
            <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addPeserta" data-action="{{route('filtered-peserta')}}">Tambah Peserta</button>
        </div>
    </div>
    <div  class="row pt-3">
        <div class="col-xl-12 table-responsive">
            <label for="">Anggota Kelompok</label>
            <table class="table table-striped" id="anggotaKelompok">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Komwil</th>
                        <th>Unit</th>
                        <th>TS</th>
                        <th>Tingkatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @php($i=1)
                @foreach ($anggotaKelompok as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item['no_peserta']}}</td>
                    <td>{{$item['name']}}</td>
                    <td>{{$item['komwil']}}</td>
                    <td>{{$item['unit']??''}}</td>
                    <td>{{$item['ts']}}</td>
                    <td>{{$item['tingkat']}}</td>
                    <td>
                        <a href="{{route('delete-tmp-anggota-kelompok',$item['id'])}}" class="text-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <button type="submit" class="btn btn-success">Simpan Kelompok</button>
        </div>
    </div>
</form>
 <!-- Modal -->
 <div class="modal fade" id="addPeserta" tabindex="-1" role="dialog" aria-labelledby="addPesertaLabel"  data-backdrop="static"
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
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="komwil">Komwil</label>
                        <select name="komwil_id" class="form-control" id="komwil">
                            <option value="">Pilih Komwil</option>
                            @foreach ($komwil as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" class="form-control" id="unit_id">
                            <option value="">Pilih Unit</option>
                            @foreach ($unit as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="ts_awal_id">Tingkat Sabuk</label>
                        <select name="ts_awal_id" class="form-control" id="ts_awal_id" disabled>
                            <option value="">Pilih Tingkat</option>
                            @foreach ($ts as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3">
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
                </div>
                <div class="col-xl-12">
                    <button type="button" class="btn btn-primary btn-filter" data-action="{{route('filtered-peserta')}}">Filter</button>
                </div>
             </div>
             <div class="row">
                 <div class="col-xl-12 table-responsive">
                    <table class="table table-striped" id="tablePeserta">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Peserta</th>
                                <th>Nama Peserta</th>
                                <th>Komwil</th>
                                <th>Unit</th>
                                <th>TS</th>
                                <th>Tingkatan</th>
                                <th>Action</th>
                            </tr>
                            <tr class="tr-clone d-none">
                                <td class="no">#</td>
                                <td class="no_peserta">No. Peserta</td>
                                <td class="name">Nama Peserta</td>
                                <td class="komwil">Komwil</td>
                                <td class="unit">Unit</td>
                                <td class="ts">TS</td>
                                <td class="tingkat">Tingkatan</td>
                                <td class="">
                                    <button type="button" class="btn btn-primary btn-peserta" onclick="addAnggotKelompok(this)">Tambahkan</button>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="tbodyPeserta">
                        </tbody>
                    </table>
                    
                 </div>
             </div>
             <div class="row">
                <div class="col-xl-12">
                    <button type="button" class="btn btn-success btn-close">Close</button>
                    <button type="button" class="btn btn-secondary btn-reset" data-action="{{route('reset-filter')}}">Reset</button>
                </div>
             </div>
         </div>
     </div>
 </div>
</div>
<script>
    $('.btn-close').click(function(){
        var url = window.location.href;   
            // if($('input[name="name"]').val()!=''){
            //     url += url.indexOf('?') > -1 ?(  $('select[name="ts_id"]').val()!=''?'&':'?')+'name='+$('input[name="name"]').val():''
            // }
            // if($('select[name="ts_id"]').val()!=''){
            //     url += url.indexOf('?') > -1 ? ( $('input[name="name"]').val()!=''?'&':'?')+'ts_id='+$('select[name="ts_id"]').val():''
            // }
        window.location.href = url;
    })
    $('.btn-filter').click(function(){
        $.get($(this).data('action'),{
            'komwil_id':$('select[name="komwil_id"]').val(),
            'unit_id':$('select[name="unit_id"]').val(),
            'ts_id':$('select[name="ts_awal_id"]').val(),
            'tingkat':$('select[name="tingkat"]').val(),
            'name':$('input[name="name"]').val(),
            'event_id':$('select[name="event_id"]').val(),
        },function(data){
            parseTable(data)
        })
    })
    $('.btn-reset').click(function(){
        $.get($(this).data('action'),function(){
            $.get($('.btn-add').data('action'),function(data){
                parseTable(data)
            })
        })
    })
    $('#anggotaKelompok').dataTable({
        paging:false
    })
    $('.btn-add').click(function(){
        $('select[name="ts_awal_id"]').val($('select[name="ts_id"]').val())
        $('.btn-filter').click()
        // $.get($(this).data('action'),function(data){
        //     parseTable(data)
        // })
    })
    function addAnggotKelompok(e)
    {
        $.get($(e).data('action'),function(data){
            $('.btn-filter').click()
        })
    }
    function parseTable(data)
    {
        console.log(data)
            html = ''
            var i =1
            html = data.map(function(e){
                console.log(e)
                clone = $('.tr-clone').clone()
                clone.removeClass('d-none').removeClass('tr-clone')
                clone.find('.no').text(i++)
                clone.find('.no_peserta').text(e.no_peserta)
                clone.find('.name').text(e.name)
                clone.find('.komwil').text(e.data_komwil.name)
                clone.find('.unit').text(e.data_unit.name)
                clone.find('.ts').text(e.data_ts.name)
                clone.find('.tingkat').text(e.tingkat)
                clone.find('.btn-peserta').attr('data-action','/admin/kelompok/set-anggota-kelompok/'+e.id)
                return clone
            })
            console.log(html)
            $('#tbodyPeserta').html(html).promise().done(function(){
                $('#tablePeserta').dataTable({
                    paging:false,
                    retrieve: true,
                })
            })
    }
</script>
@endsection