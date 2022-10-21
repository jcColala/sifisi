<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesFuncionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.roles_funciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idroles");
            $table->foreign('idroles')->references('id')->on('seguridad.roles');
            $table->unsignedBigInteger("idfunciones");
            $table->foreign('idfunciones')->references('id')->on('seguridad.funciones');
            $table->softDeletes();
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
        Schema::dropIfExists('seguridad.roles_funciones');
    }
}
