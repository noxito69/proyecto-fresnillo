<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquetas_contratistas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_equipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie')->unique();
            $table->string('usuario');
            $table->string('empresa');
            $table->date('fecha_vigencia');
            $table->date('fecha_actual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void 
     */
    public function down()
    {
        Schema::dropIfExists('etiquetas_contratistas');
    }
};
