<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // OJO: el nombre en minúsculas. En Linux MySQL distingue mayúsculas en
        // los nombres de tabla y la tabla `reserva` apunta a `empleado`.
        Schema::create('empleado', function (Blueprint $table) {
            // Un empleado es un usuario: comparte su id (no es autoincremental).
            $table->unsignedBigInteger('id_empleado')->primary();
            $table->date('fecha_contratacion');
            $table->string('puesto');
            $table->timestamps();

            $table->foreign('id_empleado')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado');
    }
};
