<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\EventMaster;
use App\Models\TS;

class DashboardController extends Controller
{
    public function peserta()
    {
        $sumKomwil = [];
        $sumTs = [];
        $sumJenjang = [];
        if(request()->has('event_alias') || auth()->user()->event_id!=null){
            if(request()->has('event_alias')) $event = EventMaster::where('event_alias',request('event_alias'))->first();
            if(auth()->user()->event_id!=null) $event = EventMaster::where('id',auth()->user()->event_id)->first();
            $sumKomwil = Peserta::selectRaw('count(*) as y,b.name')
                        ->join('komwil as b','b.id','peserta.komwil_id')
                        ->where('event_id',$event->id)
                        ->groupBy('b.name')->get(); 
            $sumTs =  Peserta::selectRaw('count(*) as y,b.name')
                        ->join('ts as b','b.id','peserta.ts_awal_id')
                        ->where('event_id',$event->id)
                        ->groupBy('b.name')->orderBy('b.id')->get(); 
            $sumJenjang =  Peserta::selectRaw('count(*) as y,tingkat as name')
                        ->where('event_id',$event->id)
                        ->groupBy('tingkat')->get(); 
        }
        return view('admin.dashboard.peserta',compact('sumKomwil','sumTs','sumJenjang'));
    }
}
