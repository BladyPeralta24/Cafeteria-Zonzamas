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
        Schema::create('producto', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre', 100);
            $table->decimal('precio_unitario', 10, 2);
            $table->integer('stock');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('cod_estanteria');
            $table->unsignedBigInteger('cod_almacen');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('categoria');
            $table->foreign('cod_estanteria')->references('cod_estanteria')->on('estanteria');
            $table->foreign('cod_almacen')->references('cod_almacen')->on('almacen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
