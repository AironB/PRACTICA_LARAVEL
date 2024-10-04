<?php

namespace Database\Seeders;

use App\Models\Accomodations;
use App\Models\Bookings;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    //creamos 10 registros random a la base de datos
    public function run(): void
    {
        //informacion random
        // User::factory(10)->create();
        //creando registros falsos para los alojamientos
        //Accomodations::factory(5)->create();
        //creando registros falsos para el booking
        Bookings::factory(10) -> create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',

        // ]);

    }
}
