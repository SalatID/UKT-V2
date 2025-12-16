<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kejuaraan\Weight;
use App\Models\Kejuaraan\PesertaKejuaraan;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KejuaraanController extends Controller
{
    public $menu;
    public function __construct(){
        $this->menu =[
            // [
            //     "nama"=>"summary",
            //     "src"=>route('kejuaraan.summary')
            // ],
            // [
            //     "nama"=>"validasi",
            //     "src"=>route('kejuaraan.validasi.home')
            // ],
            [
                "nama"=>"kasir",
                "src"=>route('kejuaraan.kasir.home')
            ],
            [
                "nama"=>"sertifikat",
                "src"=>route('kejuaraan.sertifikat.home')
            ],
            [
                "nama"=>"sk",
                "src"=>route('kejuaraan.sk.home')
            ],
            [
                "nama"=>"List Semua",
                "src"=>route('kejuaraan.cetak.list')
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
    public function set_nama_pic()
    {
        $nama_pic = request('nama_pic');
        request()->session()->put('nama_pic',$nama_pic);
        return redirect()->route('kejuaraan.cetak');
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
            if(array_key_exists('orderBy',$req)){
                if($req['orderBy']=='nama_peserta'){
                    $data = PesertaKejuaraan::orderBy('nama_peserta')->orderBy('nama_kontingen');
                }else{
                    $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta');
                }
                unset($req['orderBy']);
            }else{
                $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta');
            }
            if(array_key_exists('nama_peserta',$req)){
                $data = $data->where('nama_peserta','like','%'.$req['nama_peserta'].'%');
                unset($req['nama_peserta']);
            }
            if(array_key_exists('nama_pelatih',$req)){
                $data = $data->where('nama_pelatih','like','%'.$req['nama_pelatih'].'%');
                unset($req['nama_pelatih']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            if(array_key_exists('nikBelumValid',$req)){
                $data = $data->where(function ($query) {
                    $query->where(DB::raw("length(nik)"),'<', 16)
                          ->orWhere(DB::raw("length(nik)"),'>', 16)
                          ->orWhere(DB::raw("RIGHT(nik,3)"), '000')
                          ->orWhere("nik", '');
                });
            }
            if(array_key_exists('bbKosong',$req)){
                $data = $data->where(function($query){
                    $query->where('berat_badan', 0)
                          ->orWhere('berat_badan', '');
                })->whereNotIn('id_weight',[19,20,21,22,23,24,43,44,45,46,47,48,66,67,68,69,70,81]);
            }
            if(array_key_exists('ktKosong',$req)){
                $data = $data->where('id_weight',0);
            }
            if(array_key_exists('usiaKosong',$req)){
                $data = $data->where('usia', 0)
                          ->orWhere('usia', '');
            }
            unset($req['nikBelumValid']);
            unset($req['bbKosong']);
            unset($req['ktKosong']);
            unset($req['usiaKosong']);
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
    public function validasi_hapus($id){
        if(PesertaKejuaraan::where('id',$id)->delete()){
            return redirect()->back()->with(['error'=>false,'message'=>'hapus berhasil']);
        }
        return redirect()->back()->with(['error'=>true,'message'=>'hapus gagal']);
    }
    public function edit_validasi()
    {
        $req = request()->all();
        $peserta = PesertaKejuaraan::where('id',$req['id']);
        if(!$peserta->exists()){
            return redirect()->back()->with(['error'=>true,'message'=>'data tidak ditemukan']);
        }
        $id = $req['id'];
        unset($req['id']);
        unset($req['_token']);
        $req['kasir_at'] = date('Y-m-d H:i:s');
        $upd = $peserta->update($req);
        if (!$upd){
            return redirect()->back()->with(['error'=>true,'message'=>'update gagal']);
        }
        return redirect()->back()->with(['error'=>false,'message'=>'update berhasil']);

    }
    public function summary()
    {
        $sum = DB::select("SELECT ps.nama_kontingen,ps.asal_kontingen,
            count(case when ps.kategori_usia='Pra Usia Dini' then ps.kategori_usia end) AS pra_usia_dini,
            count(case when ps.kategori_usia='Usia Dini 1' then ps.kategori_usia end) AS usia_dini_1,
            count(case when ps.kategori_usia='Usia Dini 2' then ps.kategori_usia end) AS usia_dini_2,
            count(case when ps.kategori_usia='Pra Remaja' then ps.kategori_usia end) AS pra_remaja
            FROM peserta_kejuaraan ps
            where deleted_at is null
            GROUP BY ps.nama_kontingen,ps.asal_kontingen
            ORDER BY ps.nama_kontingen");
        $total = PesertaKejuaraan::count();
        $validPay = PesertaKejuaraan::where('sudah_bayar','Y')->count();
        $validData = PesertaKejuaraan::where('sudah_validasi','Y')->count();
        $invalidNik = collect(\DB::select("SELECT 
            COUNT(case when length(pk.nik)<16 then pk.nik END) lower_sixty,
            COUNT(case when length(pk.nik)>16 then pk.nik END) upper_sixty,
            COUNT(case when RIGHT(pk.nik,3)='000' then pk.nik END) zero_tri,
            COUNT(case when pk.nik = '' then pk.nik END) zero
            FROM peserta_kejuaraan pk where deleted_at is null"))->first();
        return view('kejuaraan.summary',compact('sum','validPay','validData','total','invalidNik'));
    }
    public function cetak_home()
    {
        return view('kejuaraan.cetak.home');
    }
    public function kasir_list()
    {
        // if (!request()->session()->has('nama_pic')){
        //     return redirect()->route('kejuaraan.cetak.home');
        // }
        $data = PesertaKejuaraan::with('weight')->where('id',0)->get();
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
            if(array_key_exists('nama_pelatih',$req)){
                $data = $data->where('nama_pelatih','like','%'.$req['nama_pelatih'].'%');
                unset($req['nama_pelatih']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            $data = $data->where($req);
            $data = $data->get();
            $cnt = $data;
            // $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
            return view('kejuaraan.cetak.list_kasir',compact('data'));
        }
        return view('kejuaraan.cetak.list_kasir',compact('data'));
    }
    public function sertifikat_list()
    {
        // if (!request()->session()->has('nama_pic')){
        //     return redirect()->route('kejuaraan.cetak.home');
        // }
        $data = PesertaKejuaraan::with('weight')->whereNotNull('kasir_at')->whereNull('sertifikat_print_at')->get();
        $sudahBayar = 0;
        $sudahValidasi = 0;
        if(count(request()->all())>0){
            $req = array_filter(request()->all(), function($value) {
                return $value !== '' && $value != null;
            });
                $data = PesertaKejuaraan::orderBy('nama_kontingen')->whereNotNull('kasir_at')->orderBy('nama_peserta');
            if(array_key_exists('nama_peserta',$req)){
                $data = $data->where('nama_peserta','like','%'.$req['nama_peserta'].'%');
                unset($req['nama_peserta']);
            }
            if(array_key_exists('nama_pelatih',$req)){
                $data = $data->where('nama_pelatih','like','%'.$req['nama_pelatih'].'%');
                unset($req['nama_pelatih']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            $data = $data->where($req);
            $data = $data->get();
            $cnt = $data;
            // $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
            return view('kejuaraan.cetak.list_sertifikat',compact('data'));
        }
        return view('kejuaraan.cetak.list_sertifikat',compact('data'));
    }
    public function sk_list()
    {
        // if (!request()->session()->has('nama_pic')){
        //     return redirect()->route('kejuaraan.cetak.home');
        // }
        $data = PesertaKejuaraan::with('weight')->whereNotNull('sertifikat_print_at')->whereNull('sk_print_at')->get();
        $sudahBayar = 0;
        $sudahValidasi = 0;
        if(count(request()->all())>0){
            $req = array_filter(request()->all(), function($value) {
                return $value !== '' && $value != null;
            });
                $data = PesertaKejuaraan::orderBy('nama_kontingen')->whereNotNull('sertifikat_print_at')->whereNull('sk_print_at')->orderBy('nama_peserta');
            if(array_key_exists('nama_peserta',$req)){
                $data = $data->where('nama_peserta','like','%'.$req['nama_peserta'].'%');
                unset($req['nama_peserta']);
            }
            if(array_key_exists('nama_pelatih',$req)){
                $data = $data->where('nama_pelatih','like','%'.$req['nama_pelatih'].'%');
                unset($req['nama_pelatih']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            $data = $data->where($req);
            $data = $data->get();
            $cnt = $data;
            // $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
            return view('kejuaraan.cetak.list_sk',compact('data'));
        }
        return view('kejuaraan.cetak.list_sk',compact('data'));
    }
    public function cetak_list()
    {
        // if (!request()->session()->has('nama_pic')){
        //     return redirect()->route('kejuaraan.cetak.home');
        // }
        $data = PesertaKejuaraan::with('weight')->where('id',0)->get();
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
            if(array_key_exists('nama_pelatih',$req)){
                $data = $data->where('nama_pelatih','like','%'.$req['nama_pelatih'].'%');
                unset($req['nama_pelatih']);
            }
            if(array_key_exists('nik',$req)){
                $data = $data->where('nik','like','%'.$req['nik'].'%');
                unset($req['nik']);
            }
            $data = $data->where($req);
            $data = $data->get();
            $cnt = $data;
            // $data = PesertaKejuaraan::orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
            return view('kejuaraan.cetak.list',compact('data'));
        }
        return view('kejuaraan.cetak.list',compact('data'));
    }
    public function cetak_sertifikat()
    {
        $cetakId = [];
        $juara = request('juara');
        foreach (request('cetak') as $key=>$val){
            $upd = PesertaKejuaraan::where('id',$key)->update([
                'sertifikat_print_at'=>date('Y-m-d H:i:s'),
                'sertifikat_pic'=>session()->get('nama_pic'),
                'juara'=>$juara[$key]
            ]);
            if($upd){
                array_push($cetakId,$key);
            }
        }
        $data = PesertaKejuaraan::whereIn('id',$cetakId)->orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
        $pdf = Pdf::loadView('kejuaraan.cetak.sbck',compact('data'));
        $pdf->setBasePath(public_path());
        return $pdf->setPaper('a4','landscape')->stream('sbck.pdf');
        dd($data);
    }
    public function cetak_sk()
    {
        $cetakId = [];
        $juara = request('juara');
        foreach (request('cetak') as $key=>$val){
            $upd = PesertaKejuaraan::where('id',$key)->update([
                'sk_print_at'=>date('Y-m-d H:i:s'),
                'sk_pic'=>session()->get('nama_pic'),
                'juara'=>$juara[$key]
            ]);
            if($upd){
                array_push($cetakId,$key);
            }
        }
        $data = PesertaKejuaraan::whereIn('id',$cetakId)->orderBy('nama_kontingen')->orderBy('nama_peserta')->get();
        $pdf = Pdf::loadView('kejuaraan.cetak.sk',compact('data'));
        $pdf->setBasePath(public_path());
        $customPaper = [0, 0, 595.28, 935.04];
        // return view('kejuaraan.cetak.sk',compact('data'));
        return $pdf->setPaper($customPaper,'portrait')->stream('sk.pdf');
    }

    public function tambah(Request $request)
    {
        $data = $request->only([
            'nama_peserta',
            'nama_kontingen',
            'jenis_kelamin',
            'kategori_usia',
            'label_weight',
            'juara',
        ]);

        $peserta = PesertaKejuaraan::create($data);

        if ($peserta) {
            return redirect()->back()->with(['error' => false, 'message' => 'Peserta berhasil ditambahkan']);
        }
        return redirect()->back()->with(['error' => true, 'message' => 'Gagal menambahkan peserta']);
    }
}
