<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovIndicadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_indicador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->unsignedInteger('idpersona_solicita');
            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->unsignedBigInteger('idproceso_uno');
            $table->unsignedBigInteger('idresponsable');
            $table->unsignedBigInteger('idelaborado');
            $table->unsignedBigInteger('idrevisado');
            $table->unsignedBigInteger('idaprobado');
            $table->string('codigo', 20);
            $table->text('descripcion');
            $table->float('version');
            $table->date('fecha_aprobado');
            $table->text('objetivo');
            $table->text('variables');
            $table->text('calculo');
            $table->text('informacion');
            $table->text('periodicidad');
            $table->text('porcentaje');
            $table->text('diagrama')->default('hola buenas tardes');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idproceso_uno')->references('id')->on('sgc.proceso_uno');
            $table->foreign('idresponsable')->references('id')->on('sgc.entidad');
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
        Schema::dropIfExists('mov_indicador');
    }
}
