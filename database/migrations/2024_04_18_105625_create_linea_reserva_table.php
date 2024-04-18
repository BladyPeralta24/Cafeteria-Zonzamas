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
        Schema::create('linea_reserva', function (Blueprint $table) {
            $table->id('id_linea');
            $table->unsignedBigInteger('id_reserva');
            $table->integer('cantidad');
            $table->decimal('importe_linea', 10, 2);
            $table->unsignedBigInteger('id_producto');
            $table->timestamps();

            $table->foreign('id_reserva')->references('id_reserva')->on('reserva');
            $table->foreign('id_producto')->references('id_producto')->on('producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_reserva');
    }
};
