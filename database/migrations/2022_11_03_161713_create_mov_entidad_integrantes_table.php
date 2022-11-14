<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovEntidadIntegrantesTable extends Migration
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
            $table->unsignedBigInteger('idtipo_accion')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('identidad')->references('id')->on('sgc.entidad');
            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idintegrante')->references('dni')->on('general.persona');
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mov_entidad_integrantes');
    }
}
