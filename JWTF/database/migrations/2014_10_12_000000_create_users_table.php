usuarios <?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('num_empleado');
            $table->string('email')->unique();
            $table->string('name',30);
            
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('rol_id')->default(3);
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->boolean('is_active')->default(false);
            $table->string('password');

            $table->foreign('num_empleado')->references('num_empleado')->on('usuarios_penmont')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};