<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  public function loginForm(Request $request)
  {
    if (Auth::check()) return redirect("/");
    return view("cauth.login");
  }

  public function login(Request $request)
  {
    if (Auth::check()) return redirect("/");
    $cred = [
      "email" => $request->input("email"),
      "password" => $request->input("password"),
    ];
    if (Auth::attempt($cred)) {
      return redirect("/");
    }
    return redirect()->back()->withErrors("Bad Credentials.")->withInput();
  }

  public function registerForm(Request $request)
  {
    if (Auth::check()) return redirect("/");

    return view("cauth.register");
  }

  public function register(Request $request)
  {
    if (Auth::check()) return redirect("/");
    $data = $request->all();

    $data["name"] = strtolower(trim($data["name"] ?? ''));
    $data["email"] = strtolower(trim($data["email"] ?? ''));
    $validate = \Validator::make($data, [
      "name" => "required|string|min:2|max:160",
      "email" => ["required", "email", "unique:users,email"],
      "password" => "required|string|min:8|max:20",
    ]);
    if ($validate->fails())
      return \redirect()->back()->withErrors($validate)->withInput();
//      return \response($validate->failed(), 200);
    $data['password'] = \Hash::make($data['password']);
    $user = User::create($data);
    Auth::login($user);
    return redirect("/");
  }

  public function logout(Request $request)
  {
    Auth::logout();
//    dd($request);
    return view("cauth.login");
  }
}
