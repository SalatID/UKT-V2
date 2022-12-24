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
use App\Models\EventMaster;
use App\Models\SummaryNilaiDetail;
use App\Models\SummaryNilai;
use App\Models\ActivityLog;
use DB;
use Validator;
use Str;
use Hash;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $this->event = new EventMaster();
    }

    public function home()
    {
        $totalPeserta = 0;
        $totalJurus =null;
        $totalPenilai = 0;
        $totalKelompok = 0;
        $jurusDinilai = [];
        $top3 = [];
        $dataNilai = [];
        $event = [];
        if(request()->has('event_alias') || auth()->user()->event_id!=null){
            if(request()->has('event_alias')) $event = EventMaster::where('event_alias',request('event_alias'))->first();
            if(auth()->user()->event_id!=null) $event = EventMaster::where('id',auth()->user()->event_id)->first();
            $totalPeserta = Peserta::where('event_id',$event->id);
            if(auth()->user()->event_id!=null) $totalPeserta = $totalPeserta->where('komwil_id',auth()->user()->komwil_id);
            $totalPeserta = $totalPeserta->count();
            $totalJurus = SummaryNilaiDetail::selectRaw('sum(jurus_dinilai)jurus_dinilai,sum(total_jurus)total_jurus')->where('event_id',$event->id)->first();
            $totalPenilai = Penilai::where('event_id',$event->id)->count();
            $totalKelompok = Kelompok::where('event_id',$event->id)->count();
    
            $jurusDinilai =DB::select("
            SELECT name,IFNULL(b.total_peserta,0)total_peserta
                FROM jurus a
                LEFT JOIN (
                    SELECT COUNT(peserta_id)total_peserta, jurus_id
                    FROM summary_nilai_detail a
                    ".(auth()->user()->event_id!=null?" join peserta b on b.id = a.peserta_id and b.komwil_id=".auth()->user()->komwil_id:"")."
                    where a.event_id = :event_id
                    GROUP BY jurus_id
                ) b ON a.id = b.jurus_id
                WHERE a.parent_id=0",['event_id'=>$event->id]);
    
            $top3 = DB::select("
            SELECT a.name,b.name nama_peserta,c.name komwil, d.name unit, pt.*
            FROM ts a
            LEFT JOIN (
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 2
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 8
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 9
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 10
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 3
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 4
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                ORDER BY nilai
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 5
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                ORDER BY nilai
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 6
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                ORDER BY nilai
                LIMIT 3)
                
                UNION
                
                (SELECT SUM(nilai)nilai,peserta_id,a.ts_awal_id,b.event_id
                FROM summary_nilai_detail b
                JOIN peserta a ON b.peserta_id = a.id
                WHERE a.ts_awal_id = 7
                GROUP BY peserta_id,a.ts_awal_id,b.event_id
                ORDER BY nilai
                LIMIT 3)
                order by nilai desc
            ) pt ON pt.ts_awal_id = a.id and pt.event_id = :event_id
            LEFT JOIN peserta b ON b.id = pt.peserta_id
            LEFT JOIN komwil c ON c.id = b.komwil_id
            LEFT JOIN unit d ON d.id = b.unit_id
            WHERE a.id NOT IN(1,11) 
            order by a.id,nilai desc
            ",['event_id'=>$event->id]);
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

        return view('admin.home',compact('totalPeserta','totalJurus','totalPenilai','totalKelompok','jurusDinilai','top3','dataNilai','event'));
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
        return response()->json(Unit::where('komwil_id',request('id'))->orderBy('name')->get());
    }

    public function updateKomwil()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>true,'message'=>'Id tidak ditemukan']); 
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->komwil->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        $params['updated_user']=auth()->user()->id;
        $ins = Komwil::where('id',request('id'))->firstOrFail()->update($params);
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
        $ins = Unit::where('id',request('id'))->firstOrFail()->update($params);
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
        $ins = Ts::where('id',request('id'))->firstOrFail()->update($params);
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
        $dataPenilai = Penilai::with(['data_komwil','data_ts'])->orderBy('name');
        if(request()->has('event_alias') || auth()->user()->event_id!=null){
           $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $dataPenilai = $dataPenilai->where('event_id',$event->id);
        }
        $dataPenilai = $dataPenilai->get();
        $komwil = Komwil::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        $event = EventMaster::all();
        return view('admin.penilai.index',compact('dataPenilai','komwil','ts','event'));
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
        $params['event_id']=request()->has('event_id')?request('event_id'):$event_data;
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
        $ins = Penilai::where('id',request('id'))->firstOrFail()->update($params);
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
        $this->jurus = new Jurus();
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->jurus->fillable)!==false;
        },ARRAY_FILTER_USE_KEY);
        // if(!array_key_exists('event_id',$params)) return redirect()->back()->with(['error'=>true,'message'=>'Harap Pilih Event']);
        $params = array_filter($params, fn($value) => !is_null($value) && $value !== '');
        $dataJurus = Jurus::with(['data_parent','data_ts'])->where($params)->get();
        $parent = Jurus::where('parent_id',0)->where('event_id',$params['event_id']??'')->get();
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
        if(auth()->user()->role!='SPADM') $params['event_id'] = auth()->user()->event_id;
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
        $ins = Jurus::where('id',request('id'))->firstOrFail()->update($params);
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
        $dataKelompok = Kelompok::with(['data_peserta','data_ts']);
        if(request()->has('event_alias')){
            $event = EventMaster::where('event_alias',request('event_alias'))->first();
            $dataKelompok = $dataKelompok->where('event_id',$event->id);
        }
        $dataKelompok = $dataKelompok->get();
        $komwil = Komwil::get();
        $ts = Ts::whereNotIn('id',[1])->get();
        return view('admin.kelompok.index',compact('dataKelompok','komwil','ts'));
    }
    public function addKelompok()
    {
        $ts = Ts::whereNotIn('id',[1])->get();
        $komwil = Komwil::get();
        $unit = Unit::orderBy('name')->get();
        $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
        $event = EventMaster::all();
        return view('admin.kelompok.addKelompok',compact('ts','unit','komwil','anggotaKelompok','event'));
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
            'event_id'=>$dataPeserta->event_id,
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
            ['event_id','=',request('event_id')],
        ];
        session()->put(auth()->user()->id.'_'.'form_data',[
            'name'=>request('name'),
            'ts_id'=>request('ts_id'),
            'event_id'=>request('event_id'),
        ]);
        $notPeserta = session()->has(auth()->user()->id.'_'.'not_peserta')?session()->get(auth()->user()->id.'_'.'not_peserta'):[];
        if(!session()->has('filter_data')) session()->put('filter_data',$sessionFilter);
        $event_data = auth()->user()->event_id;
        $peserta = Peserta::with(['data_komwil','data_unit','data_ts'])->where($sessionFilter)->whereNotIn('id',$notPeserta)->whereNull('kelompok_id');
        if(auth()->user()->role!=='SPADM')$peserta=$peserta->where('event_id',$event_data);
        return response()->json($peserta->get());
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
        $params['event_id']=request()->has('event_id')?request('event_id'):$event_data;
        return DB::transaction(function() use ($params){
            $peserta=[];
            $sessionFilter=[];
            if(request()->has('jumlah')){
                $sessionFilter = [
                    ['komwil_id','like',request('komwil_id')??'%'],
                    ['unit_id','like',request('unit_id')??'%'],
                    ['ts_awal_id','like',request('ts_id')??'%'],
                    ['tingkat','like',request('tingkat')??'%'],
                    ['event_id','=',request('event_id')],
                ];
                // dd(ceil(Peserta::with(['data_komwil','data_unit','data_ts'])->where($sessionFilter)->whereNull('kelompok_id')->count()/(request('jumlah')??10)));
            }
            $name = $params['name'];
            $z=1;
            $totalRow = (request()->has('jumlah')?ceil(Peserta::with(['data_komwil','data_unit','data_ts'])->where($sessionFilter)->whereNull('kelompok_id')->count()/(request('jumlah')??10)):1);
            for($i=0;$i<$totalRow;$i++){
                if(request()->has('jumlah')) $params['name'] =  $name.' '.($z++);
                $ins = Kelompok::create($params);
                $id = $ins->id;
                if($ins){
                        if(request()->has('jumlah')){
                            $latest =Peserta::with(['data_komwil','data_unit','data_ts'])->where($sessionFilter)->whereNull('kelompok_id')->get();
                            $peserta = $latest->random(min($latest->count(), (request('jumlah')??10)));
                        }
                        $anggotaKelompok = count($peserta)>0?$peserta:session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
                        $insSuccess = 0;
                        foreach(($anggotaKelompok) as $val){
                            $insPeserta = Peserta::where('id',$val['id'])->where('event_id',$params['event_id'])->update([
                                'kelompok_id'=>$id
                            ]);
                            if($insPeserta)  $insSuccess++;
                        }
                    
                }
            }
            // dd($i);
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
        $unit = Unit::orderBy('name')->get();
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
            $upd = Kelompok::where('id',request('id'))->firstOrFail()->update($params);
            $id = request('id');
            if($upd){
                $anggotaKelompok = session()->get(auth()->user()->id.'_'.'anggota_kelompok')??[];
                $updSuccess = 0;
                foreach($anggotaKelompok as $val){
                    $updSuccess++;
                    Peserta::where('id',$val['id'])->firstOrFail()->update([
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
            
            // if($upd){
                $anggotaKelompok = $kelompok->first()->data_peserta??[];
                $updSuccess = 0;
                foreach($anggotaKelompok as $val){
                    $updSuccess++;
                    Peserta::where('id',$val['id'])->update([
                        'kelompok_id'=>null
                    ]);
                }
                $upd = $kelompok->update([
                    'deleted_at'=>date('Y-m-d H:i:s'),
                    'deleted_user'=>auth()->user()->id
                ]);
                $id = request('id');
            // }
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
        $unit = Unit::orderBy('name')->get();
        $event = EventMaster::get();
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
        $params['password']=Hash::make(request('password'));
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
        $ins = User::where('id',$id)->firstOrFail()->update([
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
        $ins = User::where('id',request('id'))->firstOrFail()->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    }
    public function event()
    {
        $dataEvent = EventMaster::all();
        $dataKomwil = Komwil::all();
        $dataBlangko = $listFile = array_values(array_diff(scandir(resource_path('views/admin/sertifikat/blangko')), array('.', '..')));
        // dd($dataBlangko);
        return view('admin.event.index',compact('dataEvent','dataKomwil','dataBlangko'));
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
        $params['event_alias']=strtolower(str_replace(' ','-',rtrim(request('name'))).'-'.date('Y',strtotime($params['tgl_mulai'])));
        $dir ='banner_event/';
        $gambar = request()->file('gambar');
        if($gambar){
            $fielName = Str::random(15).'_'.$params['event_alias'].".".$gambar->getClientOriginalExtension();
            $gambar->move($dir,$fielName);
            $params['gambar']=$dir.$fielName;
        }
        // dd($params);
        $ins = EventMaster::create($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Tambah Berhasil':'Tambah Gagal'
        ]);
    }
    public function jsonEvent($id)
    {
        return response()->json(EventMaster::where('id',$id)->first());
    }
    public function deleteEvent($id)
    {
        $ins = EventMaster::where('id',$id)->update([
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
        $ins = EventMaster::where('id',request('id'))->firstOrFail()->update($params);
        return redirect()->back()->with([
            'error'=>!$ins,
            'message'=>$ins?'Update Berhasil':'Update Gagal'
        ]);
    } 
    public function activityLog()
    {
        $this->activityLog = new ActivityLog();
        $params = array_filter(request()->all(),function($key){
            return in_array($key,$this->activityLog->fillable)!==false && request($key)!=null;
        },ARRAY_FILTER_USE_KEY);
        $dataLog = $this->activityLog->where($params)->limit(50)->orderBy('id','desc')->get(); 
        return view('admin.log.activity',compact('dataLog'));
    }
    public function copyData()
    {
        return view('admin.tools.copyData');
    }
    public function copyJurus()
    {
        $event_sumber = Jurus::where('event_id',request('event_sumber'))->where('parent_id',0);
        if($event_sumber->count()==0) return redirect()->back()->with(['error'=>true,'message'=>'Jurus Event Sumber Tidak ditemukan']);
        $event_sumber = $event_sumber->get()->toArray();
        $insCnt = 0;
        foreach($event_sumber as $value){
            $parent_before = $value['id'];
            $value['event_id']=request('event_tujuan');
            $ins = Jurus::create($value);
            if($ins) {
                $insCnt++;
                $childs = Jurus::where('event_id',request('event_sumber'))->where('parent_id',$parent_before);
                if(!$childs->count()==0) {
                    $childs = $childs->get()->toArray();
                    foreach($childs as $child){
                        $insCnt++;
                        $child['event_id']=request('event_tujuan');
                        $child['parent_id']=$ins->id;
                        $insC = Jurus::create($child);
                    }
                }
            }
        }
        $event_sumber = Jurus::where('event_id',request('event_sumber'))->get();
        return redirect()->back()->with([
            'error'=>!($insCnt==count($event_sumber??[])),
            'message'=>$insCnt==count($event_sumber??[])?'Copy Berhasil '.$insCnt.' row':'Copy Gagal'
        ]);
    }
    public function copyPeserta()
    {
        $insCnt = 0;
        $pesertaAsal =  Peserta::where('event_id',request('event_sumber'))->get();
        if($pesertaAsal->count()==0) return redirect()->back()->with(['error'=>true,'message'=>'Peserta tidak ditemukan']);
        $pesertaAsal = $pesertaAsal->toArray();
        foreach($pesertaAsal as $val){
            $peserta = Peserta::where('event_id',request('event_tujuan'))->where([
                ['name',$val['name']],
                ['tgl_lahir',$val['tgl_lahir']]
            ]);
            if(!$peserta->exists()){
                $val['event_id'] = request('event_tujuan');
                Peserta::create($val);
                $insCnt++;
            }
        }
        return redirect()->back()->with([
            'error'=>false,
            'message'=>'Copy Berhasil '.$insCnt.' row'
        ]);
    }
    public function copyPenilai()
    {
        $insCnt = 0;
        $penilaiAsal =  Penilai::where('event_id',request('event_sumber'))->get();
        if($penilaiAsal->count()==0) return redirect()->back()->with(['error'=>true,'message'=>'Penilai tidak ditemukan']);
        $penilaiAsal = $penilaiAsal->toArray();
        foreach($penilaiAsal as $val){
            $peserta = Penilai::where('event_id',request('event_tujuan'))->where([
                ['name',$val['name']]
            ]);
            if(!$peserta->exists()){
                $val['event_id'] = request('event_tujuan');
                Penilai::create($val);
                $insCnt++;
            }
        }
        return redirect()->back()->with([
            'error'=>false,
            'message'=>'Copy Berhasil '.$insCnt.' row'
        ]);
    }
    public function formulir()
    {
        return view('admin.tools.formulir');
    }
    public function penilaianManual()
    {
        $dataKelompok = Kelompok::with(['data_peserta','data_ts','data_event'])->where('id','like',(request('kelompok_id')??'').'%')->where('event_id',request('event_id'))->get();
        $pdf = Pdf::loadView('admin.tools.formulir.penilaian',compact('dataKelompok'));
        return $pdf->setPaper('a4')->stream('form-nilai-manual_'.(request('kelompok_id')!='' && $dataKelompok !=null? $dataKelompok[0]->name:''));
    }
    public function absensiPeserta()
    {
        $dataEvent = EventMaster::where('id',request('event_id'))->first();
        $dataPeserta =Peserta::with(['data_komwil','data_unit','data_ts']);
        if(auth()->user()->role!=='SPADM')$dataPeserta = $dataPeserta->where(['komwil_id'=>auth()->user()->komwil_id]);
        
        if(count(request()->all())>0){
            $this->peserta = new Peserta();
            $params = request()->all();
            $params = array_filter(request()->all(),function($key) use($params){
                return in_array($key,$this->peserta->fillable)!==false && $params[$key]!=null;
            },ARRAY_FILTER_USE_KEY);
            if(request()->has('ts_id') && request('ts_id')!=null) $params['ts_awal_id']=request('ts_id');
            $dataPeserta = $dataPeserta->where($params);
            if(request('no_peserta_from')!='' && request('no_peserta_to')!='') $dataPeserta = $dataPeserta->where('no_peserta','>=',request('no_peserta_from'))->where('no_peserta','<=',request('no_peserta_to'));
        }
        
        $dataPeserta = $dataPeserta->orderBy('name')->orderBy('no_peserta')->take(55)->get();
        $dataPeserta = $dataPeserta->sortBy(function($query){
            return $query->data_unit->name;
         })->sortBy(function($query){
            return $query->data_komwil->name;
        })->all();
        $pdf = Pdf::loadView(request('view'),compact('dataPeserta','dataEvent'));
        return $pdf->setPaper('a4')->stream('form-nilai-manual_'.(request('kelompok_id')!='' && $dataPeserta !=null? $dataPeserta[0]->name:''));
    }
}
