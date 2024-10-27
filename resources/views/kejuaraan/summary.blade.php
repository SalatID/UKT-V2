@extends('kejuaraan.index')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered table-hover col-6">
            <thead>
                <tr>
                    <th class="text-center bg-success">Total Peserta</th>
                    <th class="text-center">Pra Usia Dini</th>
                    <th class="text-center">Usia Dini 1</th>
                    <th class="text-center">Usia Dini 2</th>
                    <th class="text-center">Pra Remaja</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center h2 bg-success totalPeserta">{{$total}}</td>
                    <td class="text-center h2" id="totalPraUd">0</td>
                    <td class="text-center h2" id="totalUd1">0</td>
                    <td class="text-center h2" id="totalUd2">0</td>
                    <td class="text-center h2" id="totalPraRemaja">0</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-hover col-6">
            <thead>
                <tr>
                    {{-- <th class="text-center bg-success">Total Peserta</th> --}}
                    <th class="text-center">Sudah Validasi Bayar</th>
                    <th class="text-center">Belum Validasi Bayar</th>
                    <th class="text-center">Sudah Validasi Data</th>
                    <th class="text-center">Belum Validasi Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- <td class="text-center h2 bg-success totalPeserta">0</td> --}}
                    <td class="text-center h2" >{{$validPay}}</td>
                    <td class="text-center h2" >{{$total-$validPay}}</td>
                    <td class="text-center h2" >{{$validData}}</td>
                    <td class="text-center h2" >{{$total-$validData}}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-hover col-6">
            <thead>
                <tr>
                    {{-- <th class="text-center bg-success">Total Peserta</th> --}}
                    <th class="text-center"></th>
                    <th class="text-center">NIK Kurang 16</th>
                    <th class="text-center">NIK Lebih 16</th>
                    <th class="text-center">NIK Akhiran 000</th>
                    <th class="text-center">NIK Kosong</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- <td class="text-center h2 bg-success totalPeserta">0</td> --}}
                    <td class="text-center h2" >NIK Belum Valid</td>
                    <td class="text-center h2" >{{$invalidNik->lower_sixty}}</td>
                    <td class="text-center h2" >{{$invalidNik->upper_sixty}}</td>
                    <td class="text-center h2" >{{$invalidNik->zero_tri}}</td>
                    <td class="text-center h2" >{{$invalidNik->zero}}</td>
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
                @php($totalPraUd=0)
                @php($totalUd1=0)
                @php($totalUd2=0)
                @php($totalPraRemaja=0)
                @foreach($sum as $val)
                <tr>
                    @php($total = $val->pra_usia_dini+$val->usia_dini_1+$val->usia_dini_2+$val->pra_remaja)
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
        <input type="hidden" id="totalPraUdI" value="{{$totalPraUd}}">
        <input type="hidden" id="totalUd1I" value="{{$totalUd1}}">
        <input type="hidden" id="totalUd2I" value="{{$totalUd2}}">
        <input type="hidden" id="totalPraRemajaI" value="{{$totalPraRemaja}}">
    </div>
    <script>
        $('#totalPraUd').text($('#totalPraUdI').val())
        $('#totalUd1').text($('#totalUd1I').val())
        $('#totalUd2').text($('#totalUd2I').val())
        $('#totalPraRemaja').text($('#totalPraRemajaI').val())
    </script>
@endsection
