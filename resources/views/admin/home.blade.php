@extends('admin.index')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Peserta Ujian</span>
                    <span class="info-box-number">{{number_format($totalPeserta)}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-walking"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jurus Sudah Dinilai</span>
                    <span class="info-box-number">
                        @if($totalJurus != null)
                            @if ($totalJurus->jurus_dinilai!=0 || $totalJurus->total_jurus!=0)
                            {{round(($totalJurus->jurus_dinilai/$totalJurus->total_jurus)*100,1)}}
                                
                            @endif
                        @endif
                        <small>%</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Penilai</span>
                    <span class="info-box-number">{{$totalPenilai}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Kelompok</span>
                    <span class="info-box-number">{{$totalKelompok}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9">
                            <p class="text-center">
                                <strong>TOP 3 Berdasarkan Tingkatan Sabuk</strong>
                            </p>
                            <div class="row">
                                @php
                                    $ts_name='';
                                    $row = 1;
                                @endphp
                                @foreach($top3 as $item)
                                    @if($ts_name != $item->name )
                                    @php($no = 1)
                                        @if($ts_name != '' )
                                            </tbody>
                                        </table>
                                    </div>  
                                        @endif

                                    <div class="col-md-4 table-responsive">
                                        <p class="text-center">
                                            <strong>{{$item->name}} {{$ts_name != '' || count($top3) == $row}}</strong>
                                        </p>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Unit</th>
                                                    <th>Komwil</th>
                                                    <th>Total Nilai</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{$item->nama_peserta}}</td>
                                                    <td>{{$item->unit}}</td>
                                                    <td>{{$item->komwil}}</td>
                                                    <td>{{$item->nilai}}</td>
                                                </tr>
                                                @if( count($top3) == $row)
                                            </tbody>
                                        </table>
                                    </div>  
                                                @endif
                                    @else
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->nama_peserta}}</td>
                                        <td>{{$item->unit}}</td>
                                        <td>{{$item->komwil}}</td>
                                        <td>{{$item->nilai}}</td>
                                    </tr>
                                    @endif
                                
                                        @php($ts_name=$item->name)
                                        @php(++$row)
                                       @endforeach     
                                        
                                                              
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <p class="text-center">
                                <strong>Jurus Sudah Dinilai / Peserta</strong>
                            </p>
                            @php($i=0)
                            @foreach ($jurusDinilai as $item)
                                {{-- @if($item->id == $jurusDinilai[$i]['jurus_id']??0) --}}
                                    <div class="progress-group">
                                        {{$item->name}}
                                        <span class="float-right"><b>{{$item->total_peserta}}</b>/{{$totalPeserta}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: {{round((($item->total_peserta)/$totalPeserta)*100,0)}}%"></div>
                                        </div>
                                    </div>
                                {{-- @endif --}}
                                @php($i++)
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
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
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#table-nilai').dataTable({
            paging:false,
            scrollY: '800px',
            scrollCollapse: true,
        })
    </script>
@endsection
