<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilai;
use App\Models\Kelompok;
use App\Models\Jurus;

class GuestController extends Controller
{
    public function index($id)
    {
        $penilai = Penilai::where('event_id',$id)->get();
        $kelompok = Kelompok::where('event_id',$id)->get();
        $event_id = $id;
        return view('guest.firstPage',compact('penilai','kelompok','event_id'));
    }
    public function setKelompok()
    {
        session()->put('sNilai',json_encode(['event_id'=>request('event_id'),'kelompok_id'=>reqeust('kelompok_id'),'penilai_id'=>request('penilai_id')]));
        return redirect('/jurus');
    }
    public function pilihJurus()
    {
        $masterJurus = Jurus::where('parent_id',0)->get();
        return view('guest.pilihJurus',compact('masterJurus'));
    }
    public function getSubJurus($id)
    {
        $dataJurus = Jurus::select('jurus.*')->leftJoin('nilai','nilai.jurus_id','jurus.id')->whereNull('nilai.jurus_id')->where('parent_id',$id)->get();
        return response()->json($dataJurus);
    }
    public function setJurus()
    {
        $sBefore = json_decode(session()->get('sNilai'),true);
        $sBefore['jurus_id'] = request('jurus_id');
        session()->put('sNilai',json_encode($sBefore));
        return redirect('/nilai');
    }
    public function nilai()
    {
        $sData = sjson_decode(session()->get('sNilai'));
        $dataKelompok = Kelompok::with('data_peserta')->where([
            'event_id'=>$sData->event_id,
            'id'=>$sData->kelompok_id
        ]);
        return view('guest.nilai',$dataKelompok);
    }
}
