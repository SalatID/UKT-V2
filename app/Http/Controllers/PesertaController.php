<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Komwil;
use App\Models\Unit;
use App\Models\Ts;
use Validator;

class PesertaController extends Controller
{
    protected $peserta;
    public function __construct()
    {
        $this->peserta = new Peserta();
    }
    public function index()
    {
        $dataPeserta =Peserta::with(['data_komwil','data_unit','data_ts'])->get();
        $komwil = Komwil::get();
        $unit = Unit::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        return view('admin.peserta.index',compact('dataPeserta','komwil','unit','ts'));
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
        $params['created_user']=auth()->user()->id;
        $event_data = session()->has('event_data')?json_encode(session()->get('event_data')):null;
        $params['event_id']=$event_data!==null?$event_data->id:0;
        $params['no_peserta']=sprintf("%03d", (Peserta::max('id')??0)+1);
        $ins = Peserta::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonPeserta($id)
    {
        return response()->json(Peserta::with(['data_komwil','data_ts'])->where('id',$id)->first());
    }

    public function updatePeserta()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->peserta->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Peserta::where('id',request('id'))->update($params);
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
}
