<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovComisionIntegrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_entidad_integrantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('identidad');
            $table->unsignedBigInteger('idestado');
            $table->unsignedBigInteger('idpersona_solicita');
            $table->unsignedBigInteger('idpersona_aprueba');
            $table->unsignedBigInteger('idintegrante');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('identidad')->references('id')->on('movsgc.mov_entidad');
            $table->foreign('idestado')->references('id')->on('movsgc.mov_estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idintegrante')->references('dni')->on('general.persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mov_comision_integrantes');
    }
}
