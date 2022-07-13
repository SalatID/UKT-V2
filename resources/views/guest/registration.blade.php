@extends('guest.index')
@section('title','Formulir Pendaftaran')
@section('sub-title')

<h4>{{$event->name}}</h4>
<span class="font-size:5px">
    {{date('d M Y',strtotime($event->tgl_mulai))}} s.d {{date('d M Y',strtotime($event->tgl_selesai))}}
    <br>
    di {{$event->lokasi}} diselenggarakan oleh {{$event->penyelenggara}}

</span>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            @include('inc.formPeserta')
        </div>
    </div>
    <script>
         $('#foto').change(function(){
            const file = this.files[0];
            console.log(file);
            if (file){
            let reader = new FileReader();
            reader.onload = function(event){
                console.log(event.target.result);
                $('#prev-foto').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
