@extends('guest.index')

@section('content')
    <table class="table" border="0">
        <tr>
            <td colspan="2">
                <br>
                <a href="{{env('APP_URL')}}/event/run/{{$alias}}">Kembali Ke Halaman Awal</a>
                <br>
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <th style="width : 20%">Penilai </th>
            <td style="width : 20%">: {{ $dataPenilai->name ?? 'Penilai Tidak Ditemukan' }}

            </td>
            <td rowspan="2" style="width : 40%">
                <b>Catatan :</b><br>
                1. Range Nilai 5-9<br>
                2. Setiap pengulangan diberi waktu istirahat 30 detik<br>
            </td>
        </tr>
        <tr>
            <th>Nama Kelompok </th>
            <td>: {{ $dataKelompok->name ?? 'Kelompok Tidak Ditemukan' }}</td>
        </tr>
        <tr>
            <th style="text-align : center; text-transform : uppercase;"colspan="3">
                <h1>
                    Materi : {{ $dataJurus->name ?? 'Jurus Tidak Ditemukan' }}

                </h1>
            </th>
        </tr>
    </table>
    <form class="" action="{{route('proc-penilaian')}}" method="post">
        <table class="table">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center" width="10%">No<br>Peserta</th>
                <th class="text-center">Nama</th>
                <th class="text-center">TS</th>
                <th class="text-center" style="width : 15%">Nilai</th>
            </tr>

            <input type="hidden" name="count" value="{{ count($dataKelompok->data_peserta) }}">
            <input type="hidden" name="penilai_id" value="{{ $dataPenilai->id }}">
            <input type="hidden" name="kelompok_id" value="{{ $dataKelompok->id }}">
            <input type="hidden" name="event_id" value="{{  json_decode(session()->get('sNilai'))->event_id }}">
            <input type="hidden" name="jurus_id" value="{{ $dataJurus->id }}">
            <input type="hidden" name="alias" value="{{ $alias }}">
            @php($i=1)
            @foreach ($dataKelompok->data_peserta as $item)
            <tr>
                <td>{{$i++}}</td>
                <td>
                    <input type="hidden" name="peserta_id[]" value="{{$item->id}}"> 
                    {{$item->no_peserta}}
                </td>
                <td>{{$item->name}}</td>
                <td>
                    {{$item->data_ts->ts_code}}
                </td>
                <td style="width : 20%">
                    <input class="form-control nilai" type="number"  name="nilai[]" step="1" min="5" max="9"></td>
            </tr>
                
            @endforeach
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">
                    <input type="submit" class="btn btn-info simpan" name="" value="Simpan" style="width: 100%">
                </td>
            </tr>
        </table>
    </form>
@endsection
