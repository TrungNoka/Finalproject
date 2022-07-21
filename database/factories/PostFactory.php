<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\Post;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_name' => $this->faker->name(),
            'category_id' =>  $this->faker->numberBetween(1,20),
            'size' => json_encode([$this->faker->numberBetween(1,20)]),
            'color' => json_encode([$this->faker->numberBetween(1,20)]),
            'price' => $this->faker->numberBetween(10000,1000000),
            'img'=>'/img/img' . $this->faker->numberBetween(1,6).'.jpg',
        ];
    }
}
