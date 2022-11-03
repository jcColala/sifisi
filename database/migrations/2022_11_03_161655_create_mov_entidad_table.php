<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovEntidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movsgc.mov_entidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado');
            $table->unsignedBigInteger('idpersona_solicita');
            $table->unsignedBigInteger('idpersona_aprueba');
            $table->string('descripcion', 120);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('idestado')->references('id')->on('movsgc.mov_estado');
            $table->foreign('idpersona_solicita')->references('dni')->on('general.persona');
            $table->foreign('idpersona_aprueba')->references('dni')->on('general.persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mov_entidad');
    }
}
