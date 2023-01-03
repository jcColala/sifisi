<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaIndicadorDos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.ficha_indicador_dos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idestado')->default(1);
            $table->foreign('idestado')->references('id')->on('sgc.estado');

            $table->unsignedBigInteger('idpersona_solicita');
            $table->foreign('idpersona_solicita')->references('id')->on('general.persona');

            $table->unsignedBigInteger('idpersona_aprueba')->nullable();
            $table->foreign('idpersona_aprueba')->references('id')->on('general.persona');

            $table->unsignedBigInteger('idindicador_dos');
            $table->foreign('idindicador_dos')->references('id')->on('sgc.indicador_dos');

            $table->unsignedBigInteger('idresponsable');
            $table->foreign('idresponsable')->references('id')->on('sgc.entidad');

            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');

            $table->unsignedBigInteger('idperiodicidad');
            $table->foreign('idperiodicidad')->references('id')->on('sgc.periodicidad');

            $table->float('version');
            $table->date("fecha_aprobado");
            $table->text('objetivo');
            $table->text('descripcion_variables');
            $table->text('forma_calculo');
            $table->string('porcentaje', 3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sgc.ficha_indicador_dos');
    }
}
