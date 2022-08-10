<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "path"=>$this->faker->url(),
            "name"=>$this->faker->name(),
            "size"=>$this->faker->numberBetween(0,1000),
            "extension"=>$this->faker->fileExtension(),
            "user_id"=>User::inRandomOrder()->first()->id,
        ];
    }
}
