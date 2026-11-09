<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->date('fecha_reserva');
            $table->time('hora_recogida');
            $table->enum('estado', ['pendiente', 'preparada', 'recogida', 'cancelada'])->default('pendiente');
            $table->decimal('impuesto_IGIC', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('descuento_total', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->unsignedBigInteger('id_cliente');
            // El empleado se asigna cuando alguien de la cafetería gestiona la reserva.
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleado')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
