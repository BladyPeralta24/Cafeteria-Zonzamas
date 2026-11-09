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
        Schema::create('estanteria', function (Blueprint $table) {
            $table->id('cod_estanteria');
            $table->unsignedBigInteger('cod_almacen');
            $table->integer('capacidad');
            $table->string('dimensiones', 50);
            $table->timestamps();

            $table->foreign('cod_almacen')->references('cod_almacen')->on('almacen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estanteria');
    }
};
