@extends('admin.index')
@section('title', 'Summary Nilai')
@section('content')
<div class="row d-flex justify-content-start mb-3">
    <button type="button" class="btn btn-success btn-calculate" data-src="{{route('calculate-nilai')}}">Kalkulasi Nilai</button>
</div>
<div class="row">
    <div class="col-xl-12 table-responsive">
        <table class="table table-striped table-bordered" id="table-nilai">
            <thead>
                <tr class="bg-info">
                    <th class="text-center">Nama Peserta</th>
                    <th class="text-center">Tingkatan Sabuk</th>
                    <th class="text-center">Unit</th>
                    <th class="text-center">Komwil</th>
                    <th class="text-center">Standar SMI</th>
                    <th class="text-center">Tradisional</th>
                    <th class="text-center">Prasetya Pesilat</th>
                    <th class="text-center">Beladiri Praktis</th>
                    <th class="text-center">Fisik Teknik</th>
                    <th class="text-center">Aerobik Tes</th>
                    <th class="text-center">Kuda-kuda Dasar</th>
                    <th class="text-center">Serang Hindar</th>
                    <th class="text-center">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataNilai as $item)
                    <tr>
                        <td class="text-center">{{$item->name}}</td>
                        <td class="text-center">{{$item->ts}}</td>
                        <td class="text-center">{{$item->unit}}</td>
                        <td class="text-center">{{$item->komwil}}</td>
                        <td class="text-center">{{$item->standar_smi}}</td>
                        <td class="text-center">{{$item->tradisional}}</td>
                        <td class="text-center">{{$item->prasetya}}</td>
                        <td class="text-center">{{$item->beladiri_praktis}}</td>
                        <td class="text-center">{{$item->fisik_teknik}}</td>
                        <td class="text-center">{{$item->aerobik}}</td>
                        <td class="text-center">{{$item->kuda_kuda}}</td>
                        <td class="text-center">{{$item->serang_hindar}}</td>
                        <td class="text-center">{{number_format($item->total_nilai,1)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#table-nilai').dataTable()
    $('.btn-calculate').click(function(){
        $.get($(this).data('src'),function(data){

        })
    })
</script>
@endsection
