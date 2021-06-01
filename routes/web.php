<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect(\route("posts.index"));
});


//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(["prefix" => "auth"], function () {
  Route::group(["middleware" => "auth.custom"], function () {
    Route::get("/logout", [\App\Http\Controllers\AuthController::class, "logout"])->name("auth.logout");
  });
  Route::get("/login", [\App\Http\Controllers\AuthController::class, "loginForm"])->name("auth.login-form");
  Route::post("/login", [\App\Http\Controllers\AuthController::class, "login"])->name("auth.login");
  Route::get("/register", [\App\Http\Controllers\AuthController::class, "registerForm"])->name("auth.register-form");
  Route::post("/register", [\App\Http\Controllers\AuthController::class, "register"])->name("auth.register");
});

Route::group(["middleware" => "auth.custom"], function () {
  Route::get("/posts/restore/{id}", [\App\Http\Controllers\PostController::class, "restore"])->name("posts.restore");
  Route::resource("/posts", \App\Http\Controllers\PostController::class, ["names" => "posts"]);
});
