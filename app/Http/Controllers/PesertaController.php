<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class PesertaController extends Controller
{
    public function index()
    {
        $dataPeserta =Peserta::with(['data_komwil','data_unit','data_ts'])->get();
        $dataKomwil = Komwil::get();
        return view('admin.peserta.index',compact('dataPeserta','dataKomwil'));
    }
}
