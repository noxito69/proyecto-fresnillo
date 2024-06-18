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
            $table->foreignId('tipo_equipo_id')->constrained('tipo_equipo')->onDelete('cascade');
            $table->foreignId('marca_id')->constrained('marca')->onDelete('cascade');
            $table->string('modelo');
            $table->string('numero_serie')->unique();
            $table->string('usuario');
            $table->foreignId('empresa_id')->constrained('empresa_contratistas')->onDelete('cascade');
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
