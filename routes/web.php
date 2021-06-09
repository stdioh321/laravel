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
  return redirect(\route("auth.login-form"));
});


//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(["prefix" => "auth"], function () {
  Route::group(["middleware" => "auth.custom"], function () {
    Route::get("/logout", [\App\Http\Controllers\AuthController::class, "logout"])->name("auth.logout");

  });
//  Route::group(["middleware" => "auth.custom:not"], function () {
    Route::get("/login", [\App\Http\Controllers\AuthController::class, "loginForm"])->name("auth.login-form");
    Route::post("/login", [\App\Http\Controllers\AuthController::class, "login"])->name("auth.login");
//  });


});
Route::group(["prefix" => "user"], function () {
  Route::group(["middleware" => "auth.custom"], function () {
    Route::get("/edit", [\App\Http\Controllers\UserController::class, "edit"])->name("user.edit");
    Route::post("/update", [\App\Http\Controllers\UserController::class, "update"])->name("user.update");
  });
  Route::group(["middleware" => "auth.custom:not"], function () {
    Route::get("/create", [\App\Http\Controllers\UserController::class, "create"])->name("user.create");
    Route::post("/store", [\App\Http\Controllers\UserController::class, "store"])->name("user.store");
  });

});

Route::group(["middleware" => "auth.custom"], function () {
  Route::get("/posts/restore/{id}", [\App\Http\Controllers\PostController::class, "restore"])->name("posts.restore");
  Route::resource("/posts", \App\Http\Controllers\PostController::class, ["names" => "posts"]);
});
