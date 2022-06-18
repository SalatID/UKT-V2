<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
         
          $sessionValue = [
            "userData"=>[
              "id"=>auth()->user()->id,
              "name"=>auth()->user()->name,
              "email"=>auth()->user()->email,
              "role"=>auth()->user()->role,
              "komwil_id"=>auth()->user()->komwil_id
            ]
          ];
          request()->session()->put("userData",$sessionValue);
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
