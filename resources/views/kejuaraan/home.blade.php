@extends('kejuaraan.index')

@section('content')
    @foreach ($menu as $item)
    <a href="{{$item['src']}}" class="btn btn-success">{{$item['nama']}}</a>
    @endforeach
@endsection
