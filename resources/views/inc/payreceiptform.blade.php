{{-- <form action="{{route('payreceipt.store')}}" method="POST">
    @csrf --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="receipt_for">Untuk Pembayaran</label>
                <input type="text" class="form-control" id="receipt_for" name="receipt_for" placeholder="Untuk Pembayaran" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="amount">Total Pembayaran</label>
                <input type="number" step="any" class="form-control" id="amount" name="amount" placeholder="Total Pembayaran" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="receipt_date">Tanggal Kwitansi</label>
                <input type="date" class="form-control" name="receipt_date" id="receipt_date">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="client">Klien</label>
                <input type="text" class="form-control" name="client" id="client">
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-start">
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
  {{-- </form> --}}