<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Ts;
use App\Models\Kelompok;
use App\Models\Penilai;
use App\Models\Jurus;
use App\Models\SummaryNilai;
use App\Models\SummaryNilaiDetail;
use App\Models\Peserta;
use App\Models\EventMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Queue;
use Validator;

class NilaiController extends Controller
{
    public function index()
    {
        $dataNilai = [];
        $param =[];
        if(count(request()->all())>0){
            $this->nilai = new Nilai();
            $params = array_filter(request()->all(),function($key){
                return in_array($key,$this->nilai->fillable)!==false && request($key)!==null;
            },ARRAY_FILTER_USE_KEY);
            // dd($params);
            // $params = array_filter($params, fn($value) => !is_null($value) && $value !== '');
            $dataNilai = Nilai::select('nilai.*')->where($params);
            // if(request('ts_id')!=null) $dataNilai = $dataNilai->join('peserta','peserta.id','nilai.peserta_id')->where('peserta.ts_awal_id',request('ts_id'));
            if(request()->has('event_alias')){
                $event = EventMaster::where('event_alias',request('event_alias'))->first();
                $dataNilai = $dataNilai->where('event_id',$event->id);
                $param = [['event_id',$event->id]];
            }
            if(request()->has('event_id') && request('event_id')!=null){
                $dataNilai = $dataNilai->where('event_id',request('event_id'));
                $param =[ ['event_id',request('event_id')]];
            }
            $dataNilai = $dataNilai->get();
        }
        $ts = Ts::all();
        $kelompok = Kelompok::where($param)->get();
        $penilai = Penilai::where($param)->get();
        $jurus = Jurus::where('parent_id','!=','0')->where($param)->get();
        return view('admin.nilai.index',compact('dataNilai','ts','kelompok','penilai','jurus'));
    }
    public function calculateNilai()
    {
        // $this->user = auth()->user();
        // return Queue::push(new \App\Jobs\CalculateNilaiJob(auth()->user()));        
        $data = Nilai::select('peserta.name','peserta.no_peserta','peserta.id as peserta_id','peserta.ts_awal_id as ts_id','d.name as nama_jurus','d.id as jurus_id','nilai.event_id','e.no_sertifikat',DB::raw('sum(nilai)nilai,COUNT(c.id)jurus_dinilai'))
                ->join('peserta','peserta.id','nilai.peserta_id')
                ->join('jurus as c','c.id','nilai.jurus_id')
                ->join('jurus as d','d.id','c.parent_id')
                ->join('event as e','e.id','nilai.event_id')
                ->groupBy('peserta.id','peserta.name','d.name','d.id','nilai.event_id','peserta.ts_awal_id','e.no_sertifikat','peserta.no_peserta')
                ->orderBy('peserta.id')
                ->get()->toArray();
        $sum_nilai=[];
        $peserta_id='';
        $insM = '';
        $insD = '';
        $summary='';
        $this->summary_nilai = new SummaryNilai();
        $this->summary_nilai_detail = new SummaryNilaiDetail();
        // dd($data);
        foreach($data as $key =>$value){
            if( $peserta_id!=$value['peserta_id']){
                $p = array_filter($value,function($key){
                    return in_array($key,$this->summary_nilai->fillable)!==false;
                },ARRAY_FILTER_USE_KEY);
                $p['no_sertifikat']=$value['no_peserta'].$p['no_sertifikat'];
                // dd($p);
                $summary = SummaryNilai::where(['event_id'=>$p['event_id'],'peserta_id'=>$p['peserta_id']]);
                if($summary->exists()){
                    $p['updated_user']=auth()->user()->id;
                    $insM = $summary->update($p);
                } else {
                    $p['created_user']=auth()->user()->id;
                    $insM = SummaryNilai::create($p);
                }
            }
            $params = array_filter($value,function($key){
                return in_array($key,$this->summary_nilai_detail->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            
            $params['nilai']=$this->summary_nilai_detail->averageParams($value['jurus_id'],$value['ts_id'])!=0?round($params['nilai']/$this->summary_nilai_detail->averageParams($value['jurus_id'],$value['ts_id']),1):0; 
            $params['total_jurus']=$this->summary_nilai_detail->averageParams($value['jurus_id'],$value['ts_id']);
            $params['kriteria']=$this->summary_nilai_detail->criteria($params['nilai']);
            
            $summary_detail = SummaryNilaiDetail::where(['peserta_id'=>$params['peserta_id'],'jurus_id'=>$params['jurus_id']]);
            
            if($summary_detail->exists()){
                $params['updated_user']=auth()->user()->id;
                $insD = $summary_detail->update($params);
            } else {
                $params['summary_id']=$insM->id??$summary->first()->id;
                $params['created_user']=auth()->user()->id;
                $insD = SummaryNilaiDetail::create($params);
            }
            
            $peserta_id=$params['peserta_id'];
        }
        $dataPeserta = Peserta::all();

        foreach ( $dataPeserta as $value){
            Peserta::where('id',$value->id)->update([
                'ts_akhir_id'=>$value->data_ts->ts_next
            ]);
        }
    }
    public function summaryNilai()
    {
        $dataNilai=[];
        $event=null;
        if(request()->has('event_alias')){
            $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $jurus = Jurus::where('event_id',$event->id)->where('parent_id',0)->get();
            $query = "
                SELECT a.name,c.name unit, d.name komwil,e.name ts,f.name ts_akhir,b.*
                FROM peserta a
                JOIN unit c ON a.unit_id = c.id
                JOIN komwil d ON a.komwil_id = d.id
                JOIN ts e ON e.id = a.ts_awal_id
                LEFT JOIN ts f ON f.id = a.ts_akhir_id
                LEFT JOIN ( SELECT ";
                    foreach($jurus as $val ){
                        $query .= "SUM(CASE WHEN jurus_id = $val->id THEN nilai END) ".(str_replace("-","_",str_replace(" ","_",strtolower($val->name)) )).",";
                    }
            $query .=  " sum(nilai) total_nilai,
                    peserta_id
                    FROM `summary_nilai_detail`
                    where event_id=:event_id
                    GROUP BY peserta_id
                ) b ON a.id = b.peserta_id
                where a.event_id=:event_id2
                    order by a.name
                ";
                $dataNilai =DB::select( $query,['event_id'=>$event->id,'event_id2'=>$event->id]);
                $event = $event->id;
        }
        return view('admin.nilai.summaryNilai',compact('dataNilai','event'));
    }
    public function cetakSertifikat()
    {
        $event = EventMaster::all();
        $kelompok = Kelompok::all();
        $eventId = null;
        if(request()->has('event_alias') || request()->has('event_id')){
            $dataEvent = EventMaster::where('event_alias',request('event_alias'))->first();
            $kelompok = Kelompok::where('event_id',$dataEvent->id??request('event_id'))->get();
            $eventId = $dataEvent->id;
        }
        return view('admin.nilai.sertifikat',compact('event','kelompok','eventId'));
    }
    public function previewSertifikat()
    {
        $validate = Validator::make(request()->all(),[
            'event_id'=>'required',
        ]);
        
        if($validate->fails()){
            foreach($validate->errors()->getMessages() as $key =>$data){
                array_push($this->error,[
                    "name"=>$key,
                    "message"=>$data[0]
                ]);
            }
            return redirect()->back()->with([
                'error'=>true,
                'message'=>'The given data was invalid',
                'data'=>$this->error
            ]);
        }

        $dataEvent = EventMaster::where('id',request('event_id'))->first();
        $muka = request('muka')??'depan';
        $blangko = request('blangko')??'off';
        $data = request('data')??'off';
        $foto = request('foto')??'off';
        $dataSertifikat = SummaryNilai::with(['data_peserta'])->where('summary_nilai.event_id',request('event_id'))->orderBy('peserta_id');
        if(request()->has('komwil_id') && request('komwil_id')!=null) $dataSertifikat = $dataSertifikat->whereHas('data_peserta',function($q){
            $q->where('komwil_id',request('komwil_id'));
        });
        if(request()->has('unit_id') && request('unit_id')!=null) $dataSertifikat = $dataSertifikat->whereHas('data_peserta',function($q){
            $q->where('unit_id',request('unit_id'));
        });
        if(request()->has('ts_id') && request('ts_id')!=null) $dataSertifikat = $dataSertifikat->whereHas('data_peserta',function($q){
            $q->where('ts_awal_id',request('ts_id'));
        });
        if(request()->has('no_peserta_from') && request('no_peserta_from')!=null && request()->has('no_peserta_to') && request('no_peserta_to')!=null) $dataSertifikat = $dataSertifikat->whereHas('data_peserta',function($q){
            $q->where('no_peserta','>=',request('no_peserta_from'));
            $q->where('no_peserta','<=',request('no_peserta_to'));
        });
        $dataSertifikat = $dataSertifikat->get();
        if($muka=='depan'){
            $pdf = Pdf::loadView($dataEvent->blangko_sertifikat,compact('dataSertifikat','blangko','foto','data'));
        } else {
            $pdf = Pdf::loadView('admin.sertifikat.belakangKomda',compact('dataSertifikat'));
        }
        $pdf->setBasePath(public_path());
        return $pdf->setPaper('a4')->stream('sertifikat.pdf');
    }
    public function jsonNilai($id)
    {
        $dataNilai = Nilai::select('nilai.*')->with(['data_peserta'])->where('id',$id);
        // if(request('ts_id')!=null) $dataNilai = $dataNilai->join('peserta','peserta.id','nilai.peserta_id')->where('peserta.ts_awal_id',request('ts_id'));
        if(request()->has('event_alias')){
            $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $dataNilai = $dataNilai->where('event_id',$event->id);
        }
        $dataNilai = $dataNilai->first();
        return response()->json($dataNilai);
    }
    public function deleteNilai($id)
    {
        $delete = Nilai::where('id',$id)->delete();
        return redirect()->back()->with([
            'error'=>!$delete,
            'message'=>$delete?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function updateNilai()
    {
        $this->nilai = new Nilai();
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->nilai->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        if(request()->has('ts_akhir_id')){
            $dataNilai = Nilai::findOrFail(request('id'));
            Peserta::where('id',$dataNilai->peserta_id)->firstOrFail()->update(['ts_akhir_id'=>request('ts_akhir_id')]);
        }
        $params['updated_user']=auth()->user()->id;
        $ins = Nilai::where('id',request('id'))->firstOrFail()->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
}
