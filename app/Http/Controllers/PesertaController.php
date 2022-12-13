<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Komwil;
use App\Models\Unit;
use App\Models\Ts;
use App\Models\EventMaster;
use Validator;
use Str;
use Crypt;

class PesertaController extends Controller
{
    protected $peserta;
    public function __construct()
    {
        $this->peserta = new Peserta();
    }
    public function index()
    {
        $dataPeserta =Peserta::with(['data_komwil','data_unit','data_ts'])->orderBy('name');
        if(auth()->user()->role!=='SPADM')$dataPeserta = $dataPeserta->where(['komwil_id'=>auth()->user()->komwil_id]);
        
        if(count(request()->all())>0){
            $this->peserta = new Peserta();
            $params = array_filter(request()->all(),function($key){
                return in_array($key,$this->peserta->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            if(request()->has('ts_id')) $params['ts_awal_id']=request('ts_id');
            $params = array_filter($params, fn($value) => !is_null($value) && $value !== '');
            $dataPeserta = Peserta::where($params);
            if(request('no_peserta_from')!='' && request('no_peserta_to')!='') $dataPeserta = $dataPeserta->where('no_peserta','>=',request('no_peserta_from'))->where('no_peserta','<=',request('no_peserta_to'));
        }
        if(request()->has('event_alias')){
            $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $dataPeserta = $dataPeserta->where('event_id',$event->id);
        }
        $dataPeserta = $dataPeserta->get();
        
        $komwil = Komwil::orderBy('name')->get();
        $unit = Unit::orderBy('name')->get();
        $ts = Ts::whereNotIn('id',[1])->get();
        $event = EventMaster::all();
        return view('admin.peserta.index',compact('dataPeserta','komwil','unit','ts','event'));
    }
    public function storePeserta()
    {
        // dd(request()->all());
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
            'ts_awal_id'=>'required',
            'komwil_id'=>'required',
            'unit_id'=>'required',
            'tempat_lahir'=>'required|max:100',
            'tgl_lahir'=>'required|max:20',
            'tingkat'=>'required'
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
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->peserta->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id??0;
        $event_data = auth()->user()->event_id??0;
        $params['event_id']=request()->has('event_id')?request('event_id'):$event_data;
        $params['no_peserta']=sprintf("%03d", (Peserta::where('event_id',$params['event_id'])->max('no_peserta')??0)+1);
        $foto = request()->file('foto');
        if($foto){
            $dir='foto_peserta/';
            $fielName = Str::random(15).'_'.str_replace(' ','-',request('name')).".".$foto->getClientOriginalExtension();
            $foto->move($dir,$fielName);
            $params['foto']=$dir.$fielName;
        }
        $ins = Peserta::create($params);
        if(auth()->user()==null){
            $throw = [
                "no_peserta"=>$params['no_peserta'],
                "event_id"=>$params['event_id']
            ];
            return redirect()->route('self-peserta',[Crypt::encrypt(json_encode( $throw))]);
        }
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonPeserta($id)
    {
        $peserta = Peserta::with(['data_komwil','data_ts'])->where(['id'=>$id]);
        if(auth()->user()->role!=='SPADM')$peserta = $peserta->where(['komwil_id'=>auth()->user()->komwil_id]);
        return response()->json($peserta->first());
    }

    public function updatePeserta()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->peserta->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $foto = request()->file('foto');
        if($foto){
            $dir='foto_peserta/';
            $fielName = Str::random(15).'_'.str_replace(' ','-',request('name')).".".$foto->getClientOriginalExtension();
            $foto->move($dir,$fielName);
            $params['foto']=$dir.$fielName;
        }
        $params['updated_user']=auth()->user()->id;
        $ins = Peserta::where('id',request('id'))->firstOrFail()->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deletePeserta($id)
    {
        $ins = Peserta::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function cetakKartu()
    {
        if(!request()->has('id')) return false;
        $dataPeserta = Peserta::whereIn('id',request('id'))->get();
        return view('admin.peserta.kartuPeserta',compact('dataPeserta'));
    }
}
