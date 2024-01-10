
    <div class="row">
        <div class="col-xl-3">
            <div class="form-group">
                <label for="komwil_id">Komwil</label>
                <select name="komwil_id" class="form-control" id="komwil" data-href="{{ route('get-json-unit') }}">
                    <option value="">Pilih Komwil</option>
                    @foreach (\App\Models\Komwil::all() as $item)
                        <option value="{{$item->id}}" {{(request('komwil_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" class="form-control" id="unit_id" disabled>
                    <option value="">Pilih Unit</option>
                    {{-- @foreach ($unit as $item)
                        <option value="{{$item->id}}" {{(request('unit_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="kelompok_id">Kelompok</label>
                <select name="kelompok_id" class="form-control" id="kelompok_id">
                    <option value="">Pilih Kelompok</option>
                    @foreach ($kelompok as $item)
                        <option value="{{$item->id}}" {{(request('kelompok_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="ts_id">Tingkat Sabuk</label>
                <select name="ts_id" class="form-control" id="ts_id">
                    <option value="">Pilih Sabuk</option>
                    @foreach (\App\Models\Ts::all() as $item)
                        <option value="{{$item->id}}" {{(request('ts_id')??'')==$item->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="event_id">Event</label>
                <select name="event_id" class="form-control" data-href="{{ route('get-json-unit') }}" required>
                    <option value="">Pilih Event</option>
                    @foreach (\App\Models\EventMaster::all() as $item)
                    <option value="{{$item->id}}" {{$item->id==$eventId?'selected':''}}>{{$item->name}} - {{$item->lokasi}} - {{$item->penyelenggara}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="no_peserta">Nomor Peserta</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="number" name="no_peserta_from" class="form-control"
                            value="{{ request('no_peserta_from') ?? '' }}" placeholder="Nomor Peserta Mulai">
                    </div>
                    <div class="col-sm-6">
                        <input type="number" name="no_peserta_to" class="form-control"
                            value="{{ request('no_peserta_to') ?? '' }}" placeholder="Nomor Peserta Sampai">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="order_by">No Peserta</label>
                        <input type="text" class="form-control" name="no_peserta" value="{{request('no_peserta')??''}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="innot" value="1" {{request('innot')==1?'checked':''}} {{request('innot')==null?'checked':''}}>
                        <label class="form-check-label">In</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="innot" value="0" {{request('innot')==='0'?'checked':''}} >
                        <label class="form-check-label">Not In</label>
                    </div>
                </div>

            </div>
            
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="kriteria">Kriteria</label>
                <select name="kriteria" class="form-control" id="kriteria">
                    <option value="">Pilih Kriteria</option>
                    <option value="KURANG" {{request('kriteria')=='KURANG'?'selected':''}}>Kurang</option>
                    <option value="BAIK" {{request('kriteria')=='BAIK'?'selected':''}}>Baik</option>
                    <option value="AMAT BAIK" {{request('kriteria')=='AMAT BAIK'?'selected':''}}>Amat Baik</option>
                </select>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="form-group">
                <label for="kriteria">Nilai Minimum</label>
                <input type="text" class="form-control" name="nilai" value="{{request('nilai')??''}}">
            </div>
        </div>
    </div>

