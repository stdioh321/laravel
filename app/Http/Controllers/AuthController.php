<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function loginForm(Request $request)
  {
    return view("cauth.login");
  }

  public function login(Request $request)
  {
    $cred = [
      "email" => $request->input("email"),
      "password" => $request->input("password"),
    ];
    if (Auth::attempt($cred)) {
      return redirect("/");
    }
    return redirect()->back()->withErrors("Bad Credentials.")->withInput();
  }

  public function logout(Request $request)
  {
    Auth::logout();
//    dd($request);
    return view("cauth.login");
  }
}
