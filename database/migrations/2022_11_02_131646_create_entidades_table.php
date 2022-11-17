<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.entidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->unsignedBigInteger('idpersona_solicita')->nullable()->default(1);
            $table->unsignedBigInteger('idpersona_aprueba')->nullable();
            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->string('descripcion', 120);
            $table->integer('cant_integrantes');
            $table->boolean('editable')->default(true);
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
        Schema::dropIfExists('entidades');
    }
}
