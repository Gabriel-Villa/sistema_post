<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nombre_post = $this->faker->unique()->sentence(2);
        
        return [
            'nombre' => $nombre_post,
            'slug' => $nombre_post,
            'descripcion' => $this->faker->text(60),
            'creado_por' => User::inRandomOrder()->first()->id,
            'fecha_creacion' => now()->format("Y-m-d H:i:s"),
            'publicado' => $this->faker->randomElement([true, false]),
        ];
    }
}
