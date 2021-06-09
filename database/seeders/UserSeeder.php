<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    if (User::count() < 1) {
      User::create([
        "name" => "Test",
        "email" => "test@myemail.com",
        "password" => \Hash::make("12345678"),
      ]);
    }
  }
}
