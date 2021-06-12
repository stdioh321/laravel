<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function loginForm(Request $request)
  {
    // Enable query log

    \Log::info("==============================================");
    \Log::info("SOME INFO");
    \Log::warning("SOME WARNING");
    \Log::error("SOME ERROR");
    \Log::info("==============================================");

    if (Auth::check()) {
      return redirect(route("posts.index"));
    }


    $users = User::all();
    $p = $users->first()->post;

    $resp = view("cauth.login", [
      "users" => $users
    ]);

    return $resp;
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
