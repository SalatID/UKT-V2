<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kejuaraan\Weight;
use App\Models\Kejuaraan\PesertaKejuaraan;

class KejuaraanController extends Controller
{
    public $menu;
    public function __construct(){
        $this->menu =[
            // [
            //     "nama"=>"summary",
            //     "src"=>route('kejuaraan.summary')
            // ],
            [
                "nama"=>"validasi",
                "src"=>route('kejuaraan.validasi.home')
            ],
            [
                "nama"=>"cetak",
                "src"=>route('kejuaraan.cetak')
            ],
        ];
    }
    public function getMenu()
    {
        return $this->menu;
    }
    public function set_nama_validasi()
    {
        $nama_validator = request('nama_validator');
        request()->session()->put('nama_validator',$nama_validator);
        return redirect()->route('kejuaraan.validasi');
    }
    public function index()
    {
        $menu = $this->menu;
        return view('kejuaraan.home',compact('menu'));
    }
    public function validasi_home()
    {
        return view('kejuaraan.validasi.home');
    }
    public function validasi()
    {
        if (!request()->session()->has('nama_validator')){
            return redirect()->route('kejuaraan.validasi.home');
        }
        $data = PesertaKejuaraan::where('id',0)->get();
        $sudahBayar = 0;
        $sudahValidasi = 0;
        if(count(request()->all())>0){
            $req = array_filter(request()->all(), function($value) {
                return $value !== '' && $value != null;
            });
            $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta');
            if(array_key_exists('nama_peserta',$req)){
                $data = $data->where('nama_peserta','like','%'.$req['nama_peserta'].'%');
                unset($req['nama_peserta']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            $data = $data->where($req);
            $data = $data->get();
            $cnt = $data;
            $sudahBayar = $cnt->where('sudah_bayar','Y')->count();
            $sudahValidasi = $cnt->where('sudah_validasi','Y')->count();
            // $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
            return view('kejuaraan.validasi.list',compact('data','sudahBayar','sudahValidasi'));
        }
        return view('kejuaraan.validasi.list',compact('data','sudahBayar','sudahValidasi'));
    }
    public function validasi_bayar()
    {
        if (request()->has('sudah_bayar')){
            foreach(request('sudah_bayar') as $idx=>$val){
                $updB = PesertaKejuaraan::where(['id'=>$idx])->update(['sudah_bayar'=>$val,'validator_bayar'=>session()->get('nama_validator')]);
            }
        }
        if (request()->has('sudah_validasi')){
            foreach(request('sudah_validasi') as $idx=>$val){
                $updB = PesertaKejuaraan::where(['id'=>$idx])->update(['sudah_validasi'=>$val,'validator'=>session()->get('nama_validator')]);
            }
        }
        return redirect()->back();
    }
    public function validasi_data()
    {

    }
    public function edit_validasi()
    {
        $req = request()->all();
        $peserta = PesertaKejuaraan::where('id',$req['id']);
        if(!$peserta->exists()){
            return redirect()->back()->with(['error'=>'true','message'=>'data tidak ditemukan']);
        }
        $id = $req['id'];
        unset($req['id']);
        unset($req['_token']);
        $upd = $peserta->update($req);
        if (!$upd){
            return redirect()->back()->with(['error'=>'true','message'=>'update gagal']);
        }
        return redirect()->back()->with(['error'=>false,'message'=>'update berhasil']);

    }
    public function cetak()
    {

    }
    public function cetak_nama()
    {

    }
    public function cetak_sk()
    {

    }
}
