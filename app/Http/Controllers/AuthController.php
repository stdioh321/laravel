<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

  public function loginForm(Request $request)
  {
    if (Auth::check()) {
      return redirect(route("posts.index"));
    }



    return view("cauth.login", [
      "users" => User::all()
    ]);
  }

  public function login(Request $request)
  {
    if (Auth::check()) {
      return redirect(route("posts.index"));
    }
    $cred = [
      "email" => $request->input("email"),
      "password" => $request->input("password"),
    ];
    if (Auth::attempt($cred)) {
      $url = $request->input("url");
//      dd($url);

//      dd($url);
      return redirect($url ?? "/");
    }
    return redirect()->back()->withErrors("Bad Credentials.")->withInput();
  }

  public function logout(Request $request)
  {
    error_log("-----------------------------------------");
    error_log("BEFORE LOGOUT");
    Auth::logout();
    error_log("AFTER LOGOUT");
    error_log("-----------------------------------------");
//    dd($request);
    return redirect(route("auth.login-form"));
  }

}
