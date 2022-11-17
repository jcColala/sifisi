<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovtipoprocesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.tipo_proceso', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 120);
            $table->string('codigo', 20);
            $table->unsignedBigInteger('idpersona_solicita');
            $table->unsignedBigInteger('idpersona_aprueba')->nullable();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idestado')->references('id')->on('sgc.estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
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
        Schema::dropIfExists('movsgc.tipo_proceso');
    }
}
