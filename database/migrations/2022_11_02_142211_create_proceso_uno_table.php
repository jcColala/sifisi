<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesounoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.proceso_uno', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->unsignedInteger('idpersona_solicita');
            $table->foreign('idpersona_solicita')->references('id')->on('general.persona');
            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->foreign('idpersona_aprueba')->references('id')->on('general.persona');
            $table->unsignedBigInteger('idproceso_cero');
            $table->foreign('idproceso_cero')->references('id')->on('sgc.proceso_cero');
            $table->unsignedBigInteger('idelaborado');
            $table->foreign('idelaborado')->references('id')->on('sgc.entidad');
            $table->unsignedBigInteger('idrevisado');
            $table->foreign('idrevisado')->references('id')->on('sgc.entidad');
            $table->unsignedBigInteger('idaprobado');
            $table->foreign('idaprobado')->references('id')->on('sgc.entidad');
            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');
            $table->boolean('editable')->default(true);
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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sgc.proceso_uno');
    }
}
