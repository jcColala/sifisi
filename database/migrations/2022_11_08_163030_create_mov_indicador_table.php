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
            $table->string('codigo', 20);
            $table->text('descripcion');
            $table->float('version');
            $table->text('objetivo')->nullable();
            $table->text('variables')->nullable();
            $table->text('calculo')->nullable();
            $table->text('informacion')->nullable();
            $table->text('periodicidad')->nullable();
            $table->text('porcentaje')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
            $table->foreign('idproceso_uno')->references('id')->on('sgc.proceso_uno');
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
