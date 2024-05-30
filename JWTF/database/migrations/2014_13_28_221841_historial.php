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
        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('num_empleado');
            $table->string('usuario');
            $table->foreignId('articulo_id')->constrained('accesorios')->onDelete('cascade');
            $table->integer('cantidad');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('centro_costos_id')->constrained('centro_costos')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('num_empleado')->references('num_empleado')->on('usuarios_penmont')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial');
    }
};
