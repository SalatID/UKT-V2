@extends('guest.index')

@section('content')
<table class="table">
    <tr>
        <td>Penilai</td>
        <td>:</td>
        <td>{{ $dataPenilai->name ?? 'Penilai Tidak Ditemukan' }}</td>
    </tr>
    <tr>
        <td>Kelompok</td>
        <td>:</td>
        <td> <b>{{ $kelompok->name??'Kelompok Tidak Ditemukan' }} -{{$kelompok->data_ts->name?? '' }}</b></td>
    </tr>
</table>
    <form action="{{ route('proc-jurus') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xl-12 mb-3">
                <select name="jurus_id" class="form-control" required data-src="{{ route('get-sub-jurus') }}">
                    <option value="">--Pilih Jurus--</option>
                    @foreach ($masterJurus as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-12 mb-3">
                <select name="sub_jurus_id" class="form-control" required disabled>
                    <option value="">--Pilih Sub Jurus--</option>

                </select>
            </div>
            <div class="col-xl-12">
                <button class="btn btn-success w-100">Simpan</button>
            </div>
        </div>
    </form>
    <div class="col-xl-12 my-4">
        <a href="{{env('APP_URL')}}/event/run/{{$alias}}">Kembali Ke Halaman Awal</a>
    </div>
    <script>
        $('select[name="jurus_id"]').change(function() {
            $.get($(this).data('src')+'?parent_id='+$(this).val(), function(data) {
                if (data.length > 0) {
                    var html = '<option value="">Pilih Sub Jurus</option>'
                    html += data.map(function(d) {
                        return '<option value="' + d.id + '">' + d.name + '</option>'
                    })
                    $('select[name="sub_jurus_id"]').html(html).promise().done(function() {
                        $('select[name="sub_jurus_id"]').attr('disabled', false)
                        if (typeof e.data('sub_jurus_id') !== 'undefined') $('select[name="sub_jurus_id"]')
                            .val(e.data('sub_jurus_id'))
                    })
                    return
                }
                $('select[name="sub_jurus_id"]').attr('disabled', true)
            })
        })
    </script>
@endsection
