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
        Schema::create('etiquetas_empleados', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_etiqueta')->unique();
            $table->string('numero_serie')->unique();
            $table->string('usuario');
            $table->string('host');
            $table->string('modelo');
            $table->string('mac');
            $table->string('correo');
            $table->string('departamento');
            $table->string('anexo');
            $table->date('fecha_vigencia');
            $table->string('ip')->nullable();
      
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
        Schema::dropIfExists('etiquetas_empleados');
    }
};
