<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komwil;
use App\Models\Unit;
use App\Models\Ts;
use App\Models\Penilai;
use App\Models\Jurus;
use App\Models\Kelompok;
use App\Models\Peserta;
use App\Models\User;
use App\Models\Event;
use DB;
use Validator;
use Str;

class AdminController extends Controller
{
    protected $komwil;
    protected $unit;
    protected $ts;
    protected $penilai;
    protected $kelompok;
    protected $jurus;
    protected $user;
    protected $event;

    public function __construct()
    {
        $this->komwil = new Komwil();
        $this->unit = new Unit();
        $this->ts = new Ts();
        $this->penilai = new Penilai();
        $this->kelompok = new Kelompok();
        $this->jurus = new Jurus();
        $this->user = new User();
        $this->event = new Event();
    }

    public function home()
    {
        return view('admin.home');
    }
    public function komwil()
    {
        $dataKomwil = Komwil::get();
        return view('admin.komwil.index',compact('dataKomwil'));
    }
    public function storeKomwil()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
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
            return in_array($key,$this->komwil->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $ins = Komwil::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonKomwil($id)
    {
        return response()->json(Komwil::where('id',$id)->first());
    }

    public function getJsonUnit()
    {
        if(!request()->has('id')) return response()->json([]);
        return response()->json(Unit::where('komwil_id',request('id'))->get());
    }

    public function updateKomwil()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->komwil->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Komwil::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deleteKomwil($id)
    {
        $ins = Komwil::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function unit()
    {
        $dataUnit = Unit::with('data_komwil')->get();
        $komwil = Komwil::get();
        return view('admin.unit.index',compact('dataUnit','komwil'));
    }
    public function storeUnit()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
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
            return in_array($key,$this->unit->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $ins = Unit::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonUnit($id)
    {
        return response()->json(Unit::with('data_komwil')->where('id',$id)->first());
    }

    public function updateUnit()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->unit->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Unit::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deleteUnit($id)
    {
        $ins = Unit::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function ts()
    {
        $dataTs = Ts::get();
        return view('admin.ts.index',compact('dataTs'));
    }
    public function storeTs()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
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
            return in_array($key,$this->ts->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $ins = Ts::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonTs($id)
    {
        return response()->json(Ts::where('id',$id)->first());
    }

    public function updateTs()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->ts->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Ts::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deleteTs($id)
    {
        $ins = Ts::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function penilai()
    {
        $dataPenilai = Penilai::with(['data_komwil','data_ts'])->get();
        $komwil = Komwil::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        return view('admin.penilai.index',compact('dataPenilai','komwil','ts'));
    }
    public function storePenilai()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
            'ts_id'=>'required',
            'komwil_id'=>'required'
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
            return in_array($key,$this->penilai->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $event_data = auth()->user()->event_id;
        $params['event_id']=$event_data;
        $ins = Penilai::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonPenilai($id)
    {
        return response()->json(Penilai::with(['data_komwil','data_ts'])->where('id',$id)->first());
    }

    public function updatePenilai()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->penilai->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Penilai::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deletePenilai($id)
    {
        $ins = Penilai::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function jurus()
    {
        $dataJurus = Jurus::with(['data_parent','data_ts'])->get();
        $parent = Jurus::where('parent_id',0)->get();
        $ts = Ts::get();
        return view('admin.jurus.index',compact('dataJurus','parent','ts'));
    }
    public function storeJurus()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
            'ts_id'=>'required',
            'parent_id'=>'required'
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
            return in_array($key,$this->jurus->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $ins = Jurus::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonJurus($id)
    {
        return response()->json(Jurus::with(['data_parent','data_ts'])->where('id',$id)->first());
    }

    public function updateJurus()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->jurus->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Jurus::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function deleteJurus($id)
    {
        $ins = Jurus::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function kelompok()
    {
        $dataKelompok = Kelompok::with(['data_peserta','data_ts'])->get();
        $komwil = Komwil::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        return view('admin.kelompok.index',compact('dataKelompok','komwil','ts'));
    }
    public function addKelompok()
    {
        $ts = Ts::whereNotIn('id',[1])->get();
        $komwil = Komwil::get();
        $unit = Unit::get();
        $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
        return view('admin.kelompok.addKelompok',compact('ts','unit','komwil','anggotaKelompok'));
    }
    public function setAnggotaKelompok($id)
    {
        
        $sessionData = session()->has(auth()->user()->id.'_'.'anggota_kelompok')?session()->get(auth()->user()->id.'_'.'anggota_kelompok'):[];
        // dd($sessionData);
        $dataPeserta = Peserta::with(['data_komwil','data_ts','data_unit'])->where('id',$id)->first();
        array_push($sessionData,[
            'id'=>$dataPeserta->id,
            'no_peserta'=>$dataPeserta->no_peserta,
            'name'=>$dataPeserta->name,
            'komwil'=>$dataPeserta->data_komwil->name,
            'unit'=>$dataPeserta->data_unit->name,
            'ts'=>$dataPeserta->data_ts->name,
            'tingkat'=>$dataPeserta->tingkat,
        ]);
        $notPeserta = session()->has(auth()->user()->id.'_'.'not_peserta')?session()->get(auth()->user()->id.'_'.'not_peserta'):[];
        array_push($notPeserta,$id);
        // dd($notPeserta);
        session()->put(auth()->user()->id.'_'.'anggota_kelompok',$sessionData);
        session()->put(auth()->user()->id.'_'.'not_peserta',$notPeserta);
        return $this->getFilteredPeserta();
    }
    public function getFilteredPeserta()
    {
        // dd(session()->get(auth()->user()->id.'_'.'not_peserta'));
        $sessionFilter = [
            ['komwil_id','like',request('komwil_id')??'%'],
            ['unit_id','like',request('unit_id')??'%'],
            ['ts_awal_id','like',request('ts_id')??'%'],
            ['tingkat','like',request('tingkat')??'%'],
        ];
        session()->put(auth()->user()->id.'_'.'form_data',[
            'name'=>request('name'),
            'ts_id'=>request('ts_id'),
        ]);
        $notPeserta = session()->has(auth()->user()->id.'_'.'not_peserta')?session()->get(auth()->user()->id.'_'.'not_peserta'):[];
        if(!session()->has('filter_data')) session()->put('filter_data',$sessionFilter);
        $event_data = auth()->user()->event_id;
        return response()->json(Peserta::with(['data_komwil','data_unit','data_ts'])->where($sessionFilter)->whereNotIn('id',$notPeserta)->whereNull('kelompok_id')->where('event_id',($event_data))->get());
    }
    public function resetFilteredPeserta()
    {
        session()->forget('filter_data');
        session()->forget(auth()->user()->id.'_'.'form_data');
        session()->forget(auth()->user()->id.'_'.'not_peserta');
        session()->forget(auth()->user()->id.'_'.'anggota_kelompok');
        session()->forget(auth()->user()->id.'_'.'not_peserta');
    }
    public function storeKelompok()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required|max:200',
            'ts_id'=>'required'
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
            return in_array($key,$this->kelompok->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $event_data = auth()->user()->event_id;
        $params['event_id']=$event_data;
        return DB::transaction(function() use ($params){
            $ins = Kelompok::create($params);
            $id = $ins->id;
            if($ins){
                $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok');
                $insSuccess = 0;
                foreach($anggotaKelompok as $val){
                    $insSuccess++;
                    Peserta::where('id',$val['id'])->update([
                        'kelompok_id'=>$id
                    ]);
                }
            }
            $this->resetFilteredPeserta();
            return redirect()->route('kelompok')->with([
                'error'=>count($anggotaKelompok)!=$insSuccess,
                'message'=>count($anggotaKelompok)==$insSuccess?'Tambah Berhasil':'Tambah Gagal'
            ]);

        });
    }
    public function deleteTmpAnggotaKel($id)
    {
        $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok');
        $notPeserta = session()->get(auth()->user()->id.'_'.'not_peserta');
        foreach($anggotaKelompok as $key=>$val){
            if($val['id']==$id) {
                unset($anggotaKelompok[$key]);
            }
        }
        unset($notPeserta[array_search($id,$notPeserta)]);
        session()->put(auth()->user()->id.'_'.'anggota_kelompok',$anggotaKelompok);
        session()->put(auth()->user()->id.'_'.'not_peserta',$notPeserta);
        return redirect()->back()->with(['error'=>false,'message'=>'Delete Berhasil']);
    }
    public function deleteAnggotaKel($id)
    {
        $sts = Peserta::where('id',$id)->update([
            'kelompok_id'=>null,
            'updated_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with(['error'=>!$sts,'message'=>!$sts?'Delete Gagal':'Delete Berhasil']);
    }
    public function editKelompok($id)
    { 
        $ts = Ts::whereNotIn('id',[1])->get();
        $komwil = Komwil::get();
        $unit = Unit::get();
        $dataKelompok = Kelompok::with('data_peserta')->where('id',$id)->first();
        $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
        // dd($anggotaKelompok);
        return view('admin.kelompok.editKelompok',compact('ts','unit','komwil','dataKelompok','anggotaKelompok'));
    }
    public function updateKelompok()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->kelompok->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $event_data = auth()->user()->event_id;
        $params['event_id']=$event_data;
        return DB::transaction(function() use ($params){
            $upd = Kelompok::where('id',request('id'))->update($params);
            $id = request('id');
            if($upd){
                $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
                $updSuccess = 0;
                foreach($anggotaKelompok as $val){
                    $updSuccess++;
                    Peserta::where('id',$val['id'])->update([
                        'kelompok_id'=>$id
                    ]);
                }
            }
            $this->resetFilteredPeserta();
            return redirect()->route('kelompok')->with([
                'error'=>count($anggotaKelompok)!=$updSuccess,
                'message'=>count($anggotaKelompok)==$updSuccess?'Tambah Berhasil':'Tambah Gagal'
            ]);

        });
    }
    public function deleteKelompok($id)
    {
        return DB::transaction(function() {
            $kelompok = Kelompok::with('data_peserta')->where('id',request('id'));
            $upd = $kelompok->update([
                'deleted_at'=>date('Y-m-d H:i:s'),
                'deleted_user'=>auth()->user()->id
            ]);
            $id = request('id');
            if($upd){
                $anggotaKelompok = $kelompok->first()->data_peserta;
                $updSuccess = 0;
                foreach($anggotaKelompok as $val){
                    $updSuccess++;
                    Peserta::where('id',$val['id'])->update([
                        'kelompok_id'=>null
                    ]);
                }
            }
            $this->resetFilteredPeserta();
            return redirect()->route('kelompok')->with([
                'error'=>count($anggotaKelompok)!=$updSuccess,
                'message'=>count($anggotaKelompok)==$updSuccess?'Tambah Berhasil':'Tambah Gagal'
            ]);

        });
    }

    public function user()
    {
        $dataUser = User::get();
        $komwil = Komwil::get();
        $unit = Unit::get();
        $event = Event::get();
        return view('admin.user.index',compact('dataUser','komwil','unit','event'));
    }
    public function storeUser()
    {
        $filter = [
            'name'=>'required|max:200',
            'email'=>'required|email',
            'komwil_id'=>'required',
            'unit_id'=>'required',
            'event_id'=>'required',
        ];
        if(!request()->has('validasi_email')){
            $filter['password'] = 'required';
            $filter['retyp_password'] = 'same:password';
        } 
        $validate = Validator::make(request()->all(),$filter);
        
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
            return in_array($key,$this->user->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $ins = User::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonUser($id)
    {
        return response()->json(User::with('data_unit')->where('id',$id)->first());
    }
    public function deleteUser($id)
    {
        $ins = User::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function updateUser()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->user->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = User::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function event()
    {
        $dataEvent = Event::all();
        $dataKomwil = Komwil::all();
        return view('admin.event.index',compact('dataEvent','dataKomwil'));
    }
    public function storeEvent()
    {
        $filter = [
            'name'=>'required|max:200',
            'penyelenggara'=>'required',
            'tgl_mulai'=>'required',
            'tgl_selesai'=>'required',
            'lokasi'=>'required',
            'komwil_id'=>'required',
        ];
        $validate = Validator::make(request()->all(),$filter);
        
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
            return in_array($key,$this->event->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['created_user']=auth()->user()->id;
        $dir ='banner_event/';
        $gambar = request()->file('gambar');
        if($gambar){
            $fielName = Str::random(15).'_'.request('name').".".$gambar->getClientOriginalExtension();
            $gambar->move($dir,$fielName);
            $params['gambar']=$dir.$fielName;
        }
        // dd($params);
        $ins = Event::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonEvent($id)
    {
        return response()->json(Event::where('id',$id)->first());
    }
    public function deleteEvent($id)
    {
        $ins = Event::where('id',$id)->update([
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted_user'=>auth()->user()->id
        ]);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function updateEvent()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->event->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $dir ='banner_event/';
        $gambar = request()->file('gambar');
        if($gambar){
            $fielName = Str::random(15).'_'.request('name').".".$gambar->getClientOriginalExtension();
            $gambar->move($dir,$fielName);
            $params['gambar']=$dir.$fielName;
        }
        $ins = Event::where('id',request('id'))->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
}
