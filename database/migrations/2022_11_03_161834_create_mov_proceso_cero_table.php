<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovProcesoCeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_proceso_cero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->unsignedInteger('idpersona_solicita');
            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->unsignedBigInteger('idtipo_proceso');
            $table->unsignedBigInteger('idcargo_responsable');
            $table->unsignedBigInteger('idcargo_elaborado');
            $table->unsignedBigInteger('idcargo_revisado');
            $table->unsignedBigInteger('idcargo_aprobado');
            $table->float('version');
            $table->date('fecha_aprobado');
            $table->text('objetivo');
            $table->text('alcance');
            $table->text('diagrama');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idtipo_proceso')->references('id')->on('sgc.tipo_proceso');
            $table->foreign('idcargo_responsable')->references('id')->on('sgc.entidades');
            $table->foreign('idcargo_elaborado')->references('id')->on('sgc.entidades');
            $table->foreign('idcargo_revisado')->references('id')->on('sgc.entidades');
            $table->foreign('idcargo_aprobado')->references('id')->on('sgc.entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mov_proceso_cero');
    }
}
