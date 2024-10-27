@extends('kejuaraan.index')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered table-hover col-6">
            <thead>
                <tr>
                    <th class="text-center">Total Peserta</th>
                    <th class="text-center">Pra Usia Dini</th>
                    <th class="text-center">Usia Dini 1</th>
                    <th class="text-center">Usia Dini 2</th>
                    <th class="text-center">Pra Remaja</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center h2" id="totalPeserta">0</td>
                    <td class="text-center h2" id="totalPraUd">0</td>
                    <td class="text-center h2" id="totalUd1">0</td>
                    <td class="text-center h2" id="totalUd2">0</td>
                    <td class="text-center h2" id="totalPraRemaja">0</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama Kontingen</th>
                    <th>Asal Kontingen</th>
                    <th>Pra Usia Dini</th>
                    <th>Usia Dini 1</th>
                    <th>Usia Dini 2</th>
                    <th>Pra Remaja</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php($totalSemua=0)
                @php($totalPraUd=0)
                @php($totalUd1=0)
                @php($totalUd2=0)
                @php($totalPraRemaja=0)
                @foreach($sum as $val)
                <tr>
                    @php($total = $val->pra_usia_dini+$val->usia_dini_1+$val->usia_dini_2+$val->pra_remaja)
                    @php($totalSemua = $totalSemua + $total)
                    @php($totalPraUd = $totalPraUd + $val->pra_usia_dini)
                    @php($totalUd1 = $totalUd1 + $val->usia_dini_1)
                    @php($totalUd2 = $totalUd2 + $val->usia_dini_2)
                    @php($totalPraRemaja = $totalPraRemaja + $val->pra_remaja)
                    <td>{{$val->nama_kontingen}}</td>
                    <td>{{$val->asal_kontingen}}</td>
                    <td>{{$val->pra_usia_dini}}</td>
                    <td>{{$val->usia_dini_1}}</td>
                    <td>{{$val->usia_dini_2}}</td>
                    <td>{{$val->pra_remaja}}</td>
                    <td>{{$total}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <input type="hidden" id="totalPesertaI" value="{{$totalSemua}}">
        <input type="hidden" id="totalPraUdI" value="{{$totalPraUd}}">
        <input type="hidden" id="totalUd1I" value="{{$totalUd1}}">
        <input type="hidden" id="totalUd2I" value="{{$totalUd2}}">
        <input type="hidden" id="totalPraRemajaI" value="{{$totalPraRemaja}}">
    </div>
    <script>
        $('#totalPeserta').text($('#totalPesertaI').val())
        $('#totalPraUd').text($('#totalPraUdI').val())
        $('#totalUd1').text($('#totalUd1I').val())
        $('#totalUd2').text($('#totalUd2I').val())
        $('#totalPraRemaja').text($('#totalPraRemajaI').val())
    </script>
@endsection
