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
        Schema::create('usuarios_penmont', function (Blueprint $table) {
            $table->id();
            $table->string('num_empleado')->unique();
            $table->string('email')->unique();
            $table->string('nombre');
            $table->foreignId('centro_costos_id')->constrained('centro_costos')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
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
        //
    }
};
