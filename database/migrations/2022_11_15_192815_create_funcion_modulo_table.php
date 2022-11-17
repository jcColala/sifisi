<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.funcion_modulo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idmodulo");
            $table->foreign('idmodulo')->references('id')->on('seguridad.modulo');
            $table->unsignedBigInteger("idfuncion");
            $table->foreign('idfuncion')->references('id')->on('seguridad.funcion');
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
        Schema::dropIfExists('seguridad.funcion_modulo');
    }
}
