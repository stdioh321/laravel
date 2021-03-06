<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::all()->first();

        for ($i=0;$i<10;$i++){
            if(Post::count() >= 10) break;
            $p = new Post();
            $p->title = Str::random(10);
            $p->content = Str::random(30);
            $p["id_user"] = $u->id;
            $p->save();
        }
    }
}
