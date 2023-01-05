<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovResponsablesProcesoUno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_responsables_proceso_uno', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->foreign('idestado')->references('id')->on('sgc.estado');

            $table->unsignedBigInteger('idpersona_solicita');
            $table->foreign('idpersona_solicita')->references('id')->on('general.persona');

            $table->unsignedBigInteger('idpersona_aprueba')->nullable();
            $table->foreign('idpersona_aprueba')->references('id')->on('general.persona');

            $table->unsignedBigInteger('idproceso_uno');
            $table->foreign('idproceso_uno')->references('id')->on('sgc.proceso_uno');

            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');

            $table->unsignedBigInteger('idcomision_responsable');
            $table->foreign('idcomision_responsable')->references('id')->on('comisiones.comision');

            $table->unsignedBigInteger('idsgc');
            $table->foreign('idsgc')->references('id')->on('sgc.responsables_proceso_uno');
            
            $table->float('version_proceso_uno');
            $table->boolean('editable')->default(true);
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
        Schema::dropIfExists('movsgc.mov_responsables_proceso_uno');
    }
}
