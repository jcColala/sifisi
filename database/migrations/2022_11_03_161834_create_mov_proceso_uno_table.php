<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovProcesounoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_proceso_uno', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->unsignedInteger('idpersona_solicita');
            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->unsignedBigInteger('idproceso_cero');
            $table->unsignedBigInteger('idelaborado');
            $table->unsignedBigInteger('idrevisado');
            $table->unsignedBigInteger('idaprobado');
            $table->string('codigo', 20);
            $table->text('descripcion');
            $table->float('version');
            $table->date('fecha_aprobado');
            $table->text('proveedores');
            $table->text('entradas');
            $table->text('salidas');
            $table->text('clientes');
            $table->text('diagrama')->default('hola buenas tardes');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idproceso_cero')->references('id')->on('sgc.proceso_cero');
            $table->foreign('idelaborado')->references('id')->on('sgc.entidad');
            $table->foreign('idrevisado')->references('id')->on('sgc.entidad');
            $table->foreign('idaprobado')->references('id')->on('sgc.entidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mov_proceso_uno');
    }
}
