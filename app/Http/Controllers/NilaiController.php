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
}
