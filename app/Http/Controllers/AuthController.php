<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventMaster;
use DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function procLogin()
    {
      $credentials = request()->only('email', 'password');
      if (auth()->attempt($credentials)) {
         if(auth()->user()->role!='SPADM'){
           if(!EventMaster::where('id',auth()->user()->event_id)->where([ ['tgl_mulai','<=',date('Y-m-d')], [DB::raw('DATE_ADD(tgl_selesai, INTERVAL 1 MONTH)'),'>=',date('Y-m-d')]])->exists()){
            return redirect()->route('login')->with(["error"=>true,"message"=>"Event Anda Sudah Berakhir, harap hubungi administrator."]);
           }
         }
          // $sessionValue = [
          //   "userData"=>[
          //     "id"=>auth()->user()->id,
          //     "name"=>auth()->user()->name,
          //     "email"=>auth()->user()->email,
          //     "role"=>auth()->user()->role,
          //     "komwil_id"=>auth()->user()->komwil_id,
          //     "event_id"=>auth()->user()->event_id
          //   ]
          // ];
          // request()->session()->put("userData",$sessionValue);
          return redirect()->route('home');;
      }
      return redirect()->back()->with(["error"=>true,"message"=>"Email atau Password salah"]);
    }

    public function logout()
    {
            // User::where(['userId'=>auth()->user()->userId])->update(['loginStatus'=>'N']);
            auth()->logout();

            request()->session()->invalidate();
        
            request()->session()->regenerateToken();
        
            return redirect('/');
    }
}
