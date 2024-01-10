@extends('admin.index')
@section('title', 'Summary Nilai')
@section('content')
@if(request()->has('event_alias'))
<div class="row d-flex justify-content-start mb-3">
    <button type="button" class="btn btn-{{(\App\Models\QueueModel::count()>0?'warning':'success')}} btn-calculate" {{(\App\Models\QueueModel::count()>0?'disabled':'')}} data-src="{{route('calculate-nilai',[$eventId])}}">{{(\App\Models\QueueModel::count()>0?'Nilai Sedang Dikalkulasi':'Kalkulasi Nilai')}}</button>
</div>
@endif
<div class="row">
    <form action="{{ route('summary-nilai') }}" >
        @include('inc.formNilai')
        <div class="row justify-content-start mb-2">
            <button type="submit" class="btn btn-primary mr-2 btn-cetak" data-src="{{ route('cetak-kartu') }}">Lihat</button>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-xl-12 table-responsive">
        <table class="table table-striped table-bordered" id="table-nilai">
            <thead>
                <tr class="bg-info">
                    <th class="text-center">No Peserta</th>
                    <th class="text-center">Nama Peserta</th>
                    <th class="text-center">TS Awal</th>
                    <th class="text-center">TS Akhir</th>
                    <th class="text-center">Unit</th>
                    <th class="text-center">Komwil</th>
                    @foreach(\App\Models\Jurus::where('event_id',$eventId)->where('parent_id',0)->get() as $val)
                    <th class="text-center">{{strtoupper($val->name)}}</th>
                    @endforeach
                    <th class="text-center">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataNilai as $item)
                    <tr>
                        <td class="text-center">{{$item->no_peserta}}</td>
                        <td class="text-center">{{$item->name}}</td>
                        <td class="text-center">{{$item->ts}}</td>
                        <td class="text-center">{{$item->ts_akhir}}</td>
                        <td class="text-center">{{$item->unit}}</td>
                        <td class="text-center">{{$item->komwil}}</td>
                        @php
                            $jurus = (array)$item;  
                            $model = new \App\Models\SummaryNilaiDetail();
                        @endphp
                        @foreach(\App\Models\Jurus::where('event_id',$eventId)->where('parent_id',0)->get() as $val)
                        <th class="text-center">
                            {{$jurus[str_replace("-","_",str_replace(" ","_",strtolower($val->name)) )]==null?'':round($jurus[str_replace("-","_",str_replace(" ","_",strtolower($val->name)) )],1)}}
                            <br>
                            {{$jurus[str_replace("-","_",str_replace(" ","_",strtolower($val->name)) )]==null?'':$model->criteria($jurus[str_replace("-","_",str_replace(" ","_",strtolower($val->name)) )]??0)}}
                        </th>
                        @endforeach
                        <td class="text-center">{{number_format($item->total_nilai,1)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#table-nilai').dataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }, 'print'
        ]
    })
    $('.btn-calculate').click(function(){
        $('.preloader').css('height','100%')
        $('.preloader').children().css("display","inline")
        $.get($(this).data('src'),function(data){
            location.reload()
        })
    })
</script>
@endsection
