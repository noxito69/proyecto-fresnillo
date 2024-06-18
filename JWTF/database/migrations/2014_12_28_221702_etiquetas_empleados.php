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
            $table->string('numero_serie');
            $table->foreignId('usuario_id')->constrained('usuarios_penmont')->onDelete('cascade');
            $table->string('host');
            $table->string('modelo');
            $table->string('tipo_equipo');
            $table->string('marca');
            $table->string('mac')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('anexo_id')->constrained('anexos')->onDelete('cascade');
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
        Schema::dropIfExists('etiquetas_empleados');
    }
};
