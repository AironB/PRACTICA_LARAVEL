<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string("booking", 10);
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->double('total_amount');
            $table->string('status',10);
            //foraneas(id_usuarios, id_alojamiento)
            //asignamos el nombre del campo, hacemos referencia al campo de la otra tabla y el nombre de la tabla
            $table->foreignId('accomodation_id')->references('id')->on ('accomodations');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
