<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AccomodationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //definimos la estructura para los datos de prueba de la tabla accomodations
    public function definition(): array
    {
        return [
            'name' => fake() -> name(),
            'address' => fake() -> address(),
            'description' => fake() -> text(),
            'image' => fake() -> text(),
        ];
    }
}
