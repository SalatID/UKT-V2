@extends('admin.index')
@section('title', 'Statistik Peserta')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="sumKomwil" style="width:100%; height:400px;" data-val="{{json_encode($sumKomwil)}}"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="sumTs" style="width:100%; height:400px;" data-val="{{json_encode($sumTs)}}"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="sumJenjang" style="width:100%; height:400px;" data-val="{{json_encode($sumJenjang)}}"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Komwil</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumKomwil as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td class="text-right">{{$value->y}} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Komwil</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumUnit as $value)
                        <tr>
                            <td>{{$value->unit}}</td>
                            <td>{{$value->komwil}}</td>
                            <td class="text-right">{{$value->y}} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tingkat Sabuk</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumTs as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td class="text-right">{{$value->y}} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tingkat Sabuk</th>
                            <th>Jenjang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumTsPt as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->tingkat}}</td>
                            <td class="text-right">{{$value->y}} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumJenjang as $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td class="text-right">{{$value->y}} orang</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    
    console.log($('#sumKomwil').data('val'))
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('sumKomwil', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Presentase Peserta x Komwil'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: JSON.parse(JSON.stringify($('#sumKomwil').data('val')))
            }]
        });

        Highcharts.chart('sumTs', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Presentase Peserta x TS'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: JSON.parse(JSON.stringify($('#sumTs').data('val')))
            }]
        });

        Highcharts.chart('sumJenjang', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Presentase Peserta x Jenjang'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: JSON.parse(JSON.stringify($('#sumJenjang').data('val')))
            }]
        });
    });
</script>
@endsection
