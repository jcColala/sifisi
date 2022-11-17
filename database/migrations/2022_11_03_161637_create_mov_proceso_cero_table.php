<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovProcesoceroTable extends Migration
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
            $table->unsignedBigInteger('idresponsable');
            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->string('codigo', 20);
            $table->text('descripcion');
            $table->text('objetivo');
            $table->text('alcance');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idtipo_proceso')->references('id')->on('sgc.tipo_proceso');
            $table->foreign('idresponsable')->references('id')->on('sgc.entidad');
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
        Schema::dropIfExists('movsgc.mov_proceso_cero');
    }
}
