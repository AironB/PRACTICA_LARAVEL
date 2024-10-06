<?php

namespace Database\Factories;

use App\Models\Accomodations;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
    public function definition(): array
    {

        return [
            'booking' => fake() -> text(10),
            'check_in_date' => fake() ->date(),
            'check_out_date' => fake() -> date(),
            'total_amount' => fake()->randomFloat(),
            'status' => 'CONFIRMED',
            //tomando registros de las tablas usuarios y alojamientos por llaves foraneas
            'accomodation_id'=> Accomodations::factory(),
            'user_id'=> User::factory(),
        ];
    }
}
