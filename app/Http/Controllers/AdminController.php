<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komwil;
use App\Models\Unit;
use App\Models\Ts;
use Validator;

class AdminController extends Controller
{
    protected $komwil;
    protected $unit;
    protected $ts;

    public function __construct()
    {
        $this->komwil = new Komwil();
        $this->unit = new Unit();
        $this->ts = new Ts();
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
            $this->code = 422;
            $this->message = "The given data was invalid.";
            $this->error = [];
            foreach($validate->errors()->getMessages() as $key =>$data){
                array_push($this->error,[
                    "name"=>$key,
                    "message"=>$data[0]
                ]);
            }
            return $this->resFormat();
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

    public function updateKomwil()
    {
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
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
            $this->code = 422;
            $this->message = "The given data was invalid.";
            $this->error = [];
            foreach($validate->errors()->getMessages() as $key =>$data){
                array_push($this->error,[
                    "name"=>$key,
                    "message"=>$data[0]
                ]);
            }
            return $this->resFormat();
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
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
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
            $this->code = 422;
            $this->message = "The given data was invalid.";
            $this->error = [];
            foreach($validate->errors()->getMessages() as $key =>$data){
                array_push($this->error,[
                    "name"=>$key,
                    "message"=>$data[0]
                ]);
            }
            return $this->resFormat();
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
        if(!request()->has('id')) return redirect()->back()->with(['error'=>!$ins,'message'=>'Id tidak ditemukan']); 
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
}
