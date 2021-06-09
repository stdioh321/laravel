<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\UniqueIgnoreCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    return view("user.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();

    $data["name"] = trim($data["name"] ?? '');
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

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    return view("user.edit");

  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $data = array_filter($request->all());
    $id = Auth::user()["id"];
    $validation = \Validator::make($data, [
      "name" => "required|min:2|max:160",
      "email" => ["required", "email", new UniqueIgnoreCase("users", "id", $id)],
      "password" => "nullable|string|min:8|max:20"
    ]);
    if ($validation->fails()) return redirect()->back()->withErrors($validation)->withInput();
    if ($oldUser = User::where("id", Auth::user()["id"])->get()->first()) {
      if (!empty($data["password"])) $data["password"] = \Hash::make($data["password"]);
      $oldUser->update($data);
      return redirect(route("user.edit"))->withInput()->with("message", "User updated.");
    }
    return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
