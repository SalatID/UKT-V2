@extends('kejuaraan.index')

@section('content')
    <div class="container login-container">
        <div class="login-box">
            <h3 class="text-center">Validasi Pembayaran dan Data</h3>
            <form action="{{route('kejuaraan.validasi.setvalidator')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="text">Nama Validator</label>
                    <input type="text" name="nama_validator" class="form-control" id="text" placeholder="Masukan Nama Validator..." required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Lanjutkan</button>
            </form>
        </div>
    </div>
@endsection
