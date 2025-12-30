@extends('admin.index')
@section('title', 'List Kelompok')
@section('content')
    <div class="row d-flex justify-content-start mb-3">
        <a href="{{route('add-kelompok')}}" class="btn btn-success" >Tambah Kelompok</a>
    </div>
    <div class="row">
        @csrf
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped table-bordered" id="tableKelompok">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelompok</th>
                        <th>TS</th>
                        <th>Penilai</th>
                        <th>Anggota</th>
                        <th>Aktif Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataKelompok as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->data_ts->name }}</td>
                            <td>
                                <select name="penilai_id" class="form-control" id="" data-id="{{$item->id}}" onchange="updatePenilai(this)" data-url="{{route('update-kelompok')}}">
                                    <option value="">Pilih Penilai</option>
                                    @foreach(\App\Models\Penilai::where('event_id',$item->event_id)->orderBy('name')->get() as $v)
                                        <option value="{{$v->id}}" {{$v->id==$item->penilai_id?'selected':''}}>{{$v->name}} - {{$v->data_ts->ts_code}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <ol>
                                    @foreach ($item->data_peserta as $p)
                                    <li>{{$p->name}}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>{{$item->data_event->name??'No Event'}} - {{$item->data_event->penyelenggara??'No Event'}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropDownOption"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropDownOption">
                                        <a class="dropdown-item" onclick="editData(this)" href="{{route('edit-kelompok',$item->id)}}">Edit</a>
                                        <a class="dropdown-item" onclick="callEditNilaiModal(this)" data-kelompok="{{$item->id}}" data-event="{{$item->event_id}}" data-ts="{{$item->ts_id}}">Edit Nilai</a>
                                        <a class="dropdown-item" onclick="deleteData(this)" href="#" data-action="{{ route('delete-kelompok', $item->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Jurus -->
    <div class="modal fade" id="addJurusModal" tabindex="-1" role="dialog" aria-labelledby="addJurusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJurusLabel">Pilih Jurus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditNilaiKelompok" method="POST" action="{{route('edit-nilai-kelompok')}}">
                        @csrf
                        <input type="hidden" name="kelompok_id" id="kelompok_id">
                        <input type="hidden" name="event_id" id="event_id">
                        <div class="form-group">
                            <label for="jurusSelect">Jurus</label>
                            <select class="form-control" id="jurusSelect" name="jurus_id" required>
                                <option value="">Pilih Jurus</option>
                                @foreach(\App\Models\Jurus::where("event_id", $item->event_id??'')->where("parent_id","!=","0")->get() as $jurus)
                                    <option class="jurus_ts_{{$jurus->ts_id}}" value="{{$jurus->id}}">{{$jurus->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="$('#formEditNilaiKelompok').submit()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
   
    <script>
        var form = $('#formKelompok')
        $('#tableKelompok').dataTable()
        function editData(e) {
            $.get($(e).data('action'), function(data) {
                console.log(data.id)
                if (typeof data.id !== 'undefined') {
                    $('#addKelompokLabel').text('Edit Kelompok')
                    form.attr('action', '{{ route('update-kelompok') }}')
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'id',
                        value:data.id
                    }).appendTo('#formKelompok');
                    $('input[name="name"]', form).val(data.name)
                    $('select[name="ts_id"]',form).val(data.ts_id)
                    $('select[name="komwil_id"]',form).val(data.data_komwil.id)
                    $('#addKelompok').modal('show')
                    return
                }
                showAllerJs({
                    error:true,
                    message:'Data Tidak Ditemukan'
                })
            })
        };
        function deleteData(e) {
            if(confirm('Hapus Kelompok?')){
                $.get($(e).data('action'),function(){
                    location.reload()
                })
            }
        }
        function updatePenilai(e){
            $.ajax({
                method:'POST',
                url:$(e).data('url'),
                data:{
                    _token:$('input[name="_token"]').val(),
                    id:$(e).data('id'),
                    penilai_id:$(e).val()
                },
                success:function(data){
                    location.reload()
                }
            })
        }
        $('.btn-add').click(function(){
            $('#addKelompokLabel').text('Tambah Kelompok')
            form.attr('action', '{{ route('store-kelompok') }}')
            $('input[name="id"]').remove()
            form.trigger("reset");
        })
        function callEditNilaiModal(e){
            let kelompok_id = $(e).data('kelompok')
            let event_id = $(e).data('event')
            let ts_id = $(e).data('ts')
            $('#kelompok_id').val(kelompok_id)
            $('#event_id').val(event_id)
            $('#jurusSelect option').hide()
            for(let i=0;i<=parseInt(ts_id);i++){
                $('.jurus_ts_'+(i)).show()
            }
            $('#addJurusModal').modal('show')
        }
    </script>
@endsection
