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
        Schema::create('reserva', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->date('fecha_reserva');
            $table->decimal('impuesto_IGIC', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_total', 10, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_empleado');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('users');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
