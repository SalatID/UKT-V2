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
use App\Models\EventMaster;
use DB;
use Queue;

class NilaiController extends Controller
{
    public function index()
    {
        $dataNilai = [];
        if(count(request()->all())>0){
            $this->nilai = new Nilai();
            $params = array_filter(request()->all(),function($key){
                return in_array($key,$this->nilai->fillable)!==false && request($key)!==null;
            },ARRAY_FILTER_USE_KEY);
            // dd($params);
            // $params = array_filter($params, fn($value) => !is_null($value) && $value !== '');
            $dataNilai = Nilai::select('nilai.*')->where($params);
            // if(request('ts_id')!=null) $dataNilai = $dataNilai->join('peserta','peserta.id','nilai.peserta_id')->where('peserta.ts_awal_id',request('ts_id'));
            $dataNilai = $dataNilai->get();
        }
        $ts = Ts::all();
        $kelompok = Kelompok::all();
        $penilai = Penilai::all();
        $jurus = Jurus::where('parent_id','!=','0')->get();
        return view('admin.nilai.index',compact('dataNilai','ts','kelompok','penilai','jurus'));
    }
    public function calculateNilai()
    {
        $this->user = auth()->user();
        return Queue::push(new \App\Jobs\CalculateNilaiJob(auth()->user()));        
    }
    public function summaryNilai()
    {
        $dataNilai=[];
        if(request()->has('event_alias')){
            $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $dataNilai = DB::select("
                SELECT a.name,c.name unit, d.name komwil,e.name ts, b.*
                FROM peserta a
                JOIN unit c ON a.unit_id = c.id
                JOIN komwil d ON a.komwil_id = d.id
                JOIN ts e ON e.id = a.ts_awal_id
                LEFT JOIN (
                    SELECT 
                    SUM(CASE WHEN jurus_id = 1 THEN nilai END) standar_smi,
                    SUM(CASE WHEN jurus_id = 2 THEN nilai END) tradisional,
                    SUM(CASE WHEN jurus_id = 12 THEN nilai END) prasetya,
                    SUM(CASE WHEN jurus_id = 14 THEN nilai END) beladiri_praktis,
                    SUM(CASE WHEN jurus_id = 15 THEN nilai END) aerobik,
                    SUM(CASE WHEN jurus_id = 16 THEN nilai END) fisik_teknik,
                    SUM(CASE WHEN jurus_id = 17 THEN nilai END) kuda_kuda,
                    SUM(CASE WHEN jurus_id = 18 THEN nilai END) serang_hindar,
                    sum(nilai) total_nilai,
                    peserta_id
                    FROM `summary_nilai_detail`
                    where event_id=:event_id
                    GROUP BY peserta_id
                ) b ON a.id = b.peserta_id
                    order by a.name
                ",['event_id'=>$event->id]);
        }
        return view('admin.nilai.summaryNilai',compact('dataNilai'));
    }
}
