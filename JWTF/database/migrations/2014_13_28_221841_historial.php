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
            $table->string('num_empleado',17);
            $table->string('usuario',50);
            $table->foreignId('articulo_id')->constrained('accesorios')->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('departamento', 255);
            $table->string('centro_costos', 255);
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
