<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoceroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.proceso_cero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->unsignedInteger('idpersona_solicita');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->unsignedBigInteger('idtipo_proceso');
            $table->foreign('idtipo_proceso')->references('id')->on('sgc.tipo_proceso');
            $table->unsignedBigInteger('idresponsable');
            $table->foreign('idresponsable')->references('id')->on('sgc.entidad');
            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->boolean('editable')->default(true);
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');
            $table->string('codigo', 20);
            $table->text('descripcion');
            $table->text('objetivo');
            $table->text('alcance');
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
        Schema::dropIfExists('sgc.proceso_cero');
    }
}
