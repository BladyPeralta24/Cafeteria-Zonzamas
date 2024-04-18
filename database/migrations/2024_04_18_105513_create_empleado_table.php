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
        //
        Schema::create('Empleado', function(Blueprint $table){
            $table->id('id_empleado');
            $table->date('fecha_contratacion');
            $table->string('puesto');
            $table->timestamps();
            $table->foreign('id_empleado')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Empleado', function(Blueprint $table){
            $table->dropForeign('id_empleado');
            $table->dropIndex('id_empleado');
            $table->dropColumn('fecha_contratacion');
        });
    }
};
