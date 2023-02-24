<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermisosEdicionPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => (string) Str::uuid(),
            'post_id' => User::inRandomOrder()->first()->id,
            'solicitado_por' => User::inRandomOrder()->first()->id,
            'estado' => 0,
        ];
    }
}
