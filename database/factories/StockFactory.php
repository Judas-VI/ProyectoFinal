<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'precio' => $this->faker->randomFloat(2, 10, 500),
            'nombre_stock' => $this->faker->words(3, true),
            'fecha_creacion' => $this->faker->date(),
            'descripcion' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(1, 100),
            'img' => $this->faker->unique()->lexify('img-??????') . '.jpg',
        ];
    }
}
