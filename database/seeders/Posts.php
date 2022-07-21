<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Post;


class Posts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $values =['1','2'];

        // DB::table('posts')->insert([
        //     'post_name' => Str::random(10),
        //     'category_id' => '1',
        //     'color'=> json_encode($values),
        //     'size'=> '1',
        //     'price'=> '9000', 
        // ]);
        Post::factory()->count(24)->create();
    }
}
