<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilai;
use App\Models\Kelompok;
use App\Models\Jurus;
use App\Models\EventMaster;
use App\Models\Nilai;
use App\Models\Komwil;
use App\Models\Unit;
use App\Models\Ts;
use App\Models\Peserta;
use DB;
use Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GuestController extends Controller
{
    public function index($alias)
    {
        session()->forget('sNilai');
        $alias =  $alias;
        $event = EventMaster::where('event_alias',$alias)->first();
        if($event==null) return redirect()->back()->with(["error"=>true,"message"=>"Event Tidak Ditemukan"]);
        $penilai = Penilai::where('event_id',$event->id)->get();
        $kelompok = Kelompok::where('event_id',$event->id)->get();
        $event_id = $event->id;
        return view('guest.firstPage',compact('penilai','kelompok','event_id','alias'));
    }
    public function selfRegistration($alias)
    {
        $komwil = Komwil::get();
        $unit = Unit::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        $event = EventMaster::where('event_alias',$alias)->first();
      return view('guest.registration',compact('komwil','unit','ts','event'));
    }
    public function setKelompok()
    {
        session()->put('sNilai',json_encode(['event_id'=>request('event_id'),'kelompok_id'=>request('kelompok_id'),'penilai_id'=>request('penilai_id'),'alias'=>request('alias')]));
        // dd(json_decode(session()->get('sNilai'),true));
        return redirect()->route('jurus');
    }
    public function pilihJurus()
    {
        $masterJurus = Jurus::where('parent_id',0)->get();
        return view('guest.pilihJurus',compact('masterJurus'));
    }
    public function getSubJurus()
    {
        if(!request()->has('parent_id')) return redirect()->back()->with(["error"=>true,"message"=>"Id tidak ditemukan"]);
        $sData = json_decode(session()->get('sNilai'));
        $kelompok = Kelompok::where('id',$sData->kelompok_id)->first();
        $id = request('parent_id');
        $dataJurus = Jurus::select('jurus.*')->leftJoin('nilai',function($join) use ($sData){
            $join->on('nilai.jurus_id','jurus.id');
            $join->on('nilai.kelompok_id',DB::raw($sData->kelompok_id));
        })->whereNull('nilai.jurus_id')->where('parent_id',$id)->where('ts_id','<=',$kelompok->ts_id)->orderBy('name')->get();
        return response()->json($dataJurus);
    }
    public function setJurus()
    {
        $sBefore = json_decode(session()->get('sNilai'),true);
        $sBefore['jurus_id'] = request('sub_jurus_id');
        session()->put('sNilai',json_encode($sBefore));
        return redirect()->route('penilaian');
    }
    public function nilai()
    {
        $sData = json_decode(session()->get('sNilai'));
        $dataKelompok = Kelompok::with(['data_peserta','data_penilai'])->where([
            'event_id'=>$sData->event_id,
            'id'=>$sData->kelompok_id
        ])->first();
        $dataPenilai = Penilai::where('id',$sData->penilai_id)->first();
        $dataJurus = Jurus::where('id',$sData->jurus_id)->first();
        $alias = $sData->alias;
        return view('guest.penilaian',compact('dataKelompok','dataJurus','dataPenilai','alias'));
    }
    public function procPenilaian()
    {
        
        if(request('count')<=0) return redirect()->route('run-event',request('alias'));
        $i=0;
        $successCnt = 0;
        DB::beginTransaction();
        foreach(request('peserta_id') as $val){
            $params = [
                'jurus_id'=>request('jurus_id'),
                'nilai'=>request('nilai')[$i]??0,
                'kelompok_id'=>request('kelompok_id'),
                'peserta_id'=>$val,
                'penguji_id'=>request('penilai_id'),
                'event_id'=>request('event_id'),
                'created_user'=>request('penilai_id')
            ];
            $i++;
            $ins = Nilai::create($params);
            DB::commit();
            if($ins){
                $successCnt = $successCnt +1 ; 
            }
        }
        if($successCnt==request('count')){
            
            return redirect()->route('run-event',[request('alias')])->with([
                'error'=>false,
                'message'=>'Tambah Berhasil'
            ]);
        } else {
            DB::rollback();
            return redirect()->back()->with([
                'error'=>true,
                'message'=>'Tambah Gagal'
            ]);
        }
        
    }
    public function peserta($no_peserta)
    {
        try {
            $decrypted = Crypt::decrypt($no_peserta);
            $peserta = Peserta::where('no_peserta',$decrypted)->first();
            $event = EventMaster::where('id',$peserta->event_id)->first();
            $qrCode = QrCode::size(200)->generate(route('self-peserta',[Crypt::encrypt($peserta->no_peserta)]));
            return view('guest.peserta',compact('event','peserta','qrCode'));
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            return false ;
        }
       
    }
}
