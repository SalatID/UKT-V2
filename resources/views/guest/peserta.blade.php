@extends('guest.index')
@section('title', 'Bukti Pendaftaran')
@section('sub-title')

<h4>{{$event->name}}</h4>
<span class="font-size:5px">
    {{date('d F Y',strtotime($event->tgl_mulai))}} s.d {{date('d F Y',strtotime($event->tgl_selesai))}}
    <br>
    di {{$event->lokasi}} diselenggarakan oleh {{$event->penyelenggara}}

</span>
@endsection
@section('content')
    <div style="width:21cm;height:29.7cm;" onload="">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('store-peserta') }}" method="POST" id="formPeserta" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_id">No Peserta</label>
                                <input type="text" class="form-control" disabled name="name" id="nama" placeholder="Nama" value="{{$peserta->no_peserta}}"
                            disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <select name="event_id" class="form-control" disabled id="event_id" readonly>
                                        <option value="">{{$event->name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" disabled name="name" id="nama" placeholder="Nama" value="{{$peserta->name}}"
                            disabled>
                        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                    </div>
                    <div class="form-group">
                        <label for="ts_awal_id">Tingkat Sabuk</label>
                        <select name="ts_awal_id" class="form-control" disabled id="ts_awal_id">
                            <option value="">{{$peserta->data_ts->name}}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="komwil">Komwil</label>
                                <select name="komwil_id" class="form-control" disabled id="komwil"
                                    data-href="{{ route('get-json-unit') }}">
                                    <option value="">{{$peserta->data_komwil->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="unit_id">Unit</label>
                                <select name="unit_id" class="form-control" disabled disabled id="unit_id">
                                    <option value="">{{$peserta->data_unit->name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tingkat">Tingkat</label>
                        <select name="tingkat" class="form-control" disabled id="tingkat">
                            <option value="">{{$peserta->tingkat}}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" disabled name="tempat_lahir" id="tempat_lahir"
                                    placeholder="Tempat Lahir" disabled value="{{$peserta->tempat_lahir}}">
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" disabled name="tgl_lahir" id="tgl_lahir"
                                    placeholder="Tanggal Lahir" disabled value="{{$peserta->tgl_lahir}}">
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row foto">
                        <div class="col-4 justity-content-center">
                            <strong class="text-center">Foto Anda</strong>
                            <br>
                            <img src="/{{$peserta->foto}}" class="img-fluid foto" id="prev-foto" width="192cm" height="256cm"
                                alt="Event Banner">

                        </div>
                        <div class="col-8">
                            <strong class="text-center ">Kartu Peserta</strong>(Potong Mengikuti Garis Putus-Putus)
                            <div style="width:92mm;height:58mm; border:1px solid black; border-style:dashed;margin-top:10px;">
                                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                                    PANITIA {{strtoupper($event->name)}}
                                </h1>
                                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:15px">
                                    {{strtoupper($event->penyelenggara)}}
                                </h1>
                                <h1 class="col-12 m-0 p-0 text-center" style="font-size:10px">
                                    {{date('d F Y',strtotime($event->tgl_mulai))}} s.d {{date('d F Y',strtotime($event->tgl_selesai))}} di {{strtoupper($event->lokasi)}}
                                </h1>
                                <hr style="background:black;height: 3px;" class="p-0 m-0 px-2 mt-1">
                                <h1 class="col-12 m-0 p-0 text-center font-weight-bold" style="font-size:90px">
                                    {{strtoupper($peserta->no_peserta)}}
                                </h1>
                                <div class="col-12 m-0 p-0 text-center font-weight-bold">
                                    {{strtoupper($peserta->name)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <span class="text-center row">Untuk cetak ulang formulir</span>
                <span class="text-center row">Scan Disini</span>

                <div class="row">
                    {!!$qrCode!!}
                </div>
            </div>
            <div class="col-sm-8">
                <p class="text-justify">
                    Dokumen ini adalah bukti sah bahwa anda sudah terdaftar dalam event {{strtoupper($event->name)}} yang diselenggarakan oleh {{strtoupper($event->penyelenggara)}} pada {{date('d F Y',strtotime($event->tgl_mulai))}} s.d {{date('d F Y',strtotime($event->tgl_selesai))}} di {{strtoupper($event->lokasi)}}, jika ada perubahan data atau data yang diiput tidak sesuai harap menghubungi panitia terkait. Terimakasih
                </p>
            </div>
            
            <br>
           
        </div>

    </div>
    <script>
        $(document).ready(function(){
            window.print()
        })
    </script>
@endsection
