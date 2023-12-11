@extends('admin.index')
@section('title', 'List Nilai')
@section('content')
    {{-- <div class="row d-flex justify-content-start mb-3">
        <button type="button" class="btn btn-success btn-add" data-toggle="modal" data-target="#addNilai">Tambah
            Nilai</button>
    </div> --}}
    @php
        $allow = [
            'SPADM','KOMDA'
        ];
    @endphp
    <form action="{{route('activity-log')}}">
        <div class="row">
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="log_name">Log Name</label>
                    <select name="log_name" class="form-control" id="log_name">
                        <option value="">Pilih</option>
                        @foreach (\App\Models\ActivityLog::select('log_name')->groupBy('log_name')->get() as $item)
                        <option value="{{$item->log_name}}" {{(request('log_name')??'')==$item->log_name?'selected':''}}>{{$item->log_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="event">Event</label>
                    <select name="event" class="form-control" id="event">
                        <option value="">Pilih</option>
                        @foreach (\App\Models\ActivityLog::select('event')->groupBy('event')->get() as $item)
                            <option value="{{$item->event}}" {{(request('event')??'')==$item->event?'selected':''}}>{{$item->event}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-group">
                    <label for="subject_type">Model</label>
                    <select name="subject_type" class="form-control" id="subject_type">
                        <option value="">Pilih</option>
                        @foreach (\App\Models\ActivityLog::select('subject_type')->groupBy('subject_type')->get() as $item)
                            <option value="{{$item->subject_type}}" {{(request('subject_type')??'')==$item->subject_type?'selected':''}}>{{$item->subject_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-4">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped" id="tableLog">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Log Name</th>
                        <th>Event</th>
                        <th>Model</th>
                        <th width="300">Properties</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($dataLog as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->log_name }}</td>
                            <td>{{ $item->event }}</td>
                            <td>{{ $item->subject_type }}</td>
                            <td><div  style="width:300px;margin:0" class="text-truncate"><a href="#" onclick="openProperties(this)"> {{ json_encode(json_decode($item->properties),JSON_PRETTY_PRINT ) }}</a></div> </td>
                            <td>{{ $item->created_at }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="propertiesModal" tabindex="-1" role="dialog" aria-labelledby="propertiesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Detail Request</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <textarea class="request-content form-control" style="height: 350px" disabled></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <script>
        $('#tableLog').dataTable()
        function openProperties(e){
            $('.request-content',$('#propertiesModal')).val($(e).text())
            $('#propertiesModal').modal('show')
        }
    </script>
@endsection
