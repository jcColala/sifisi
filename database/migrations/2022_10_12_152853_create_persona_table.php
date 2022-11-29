<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.persona', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idescuela');
            $table->foreign('idescuela')->references('id')->on('facultad.escuela');
            $table->unsignedBigInteger('idestadopersona');
            $table->foreign('idestadopersona')->references('id')->on('general.estadopersona');
            $table->unsignedBigInteger('idtipopersona');
            $table->foreign('idtipopersona')->references('id')->on('general.tipopersona');
            //$table->unsignedBigInteger('idsemestre_actual');
            //$table->foreign('idsemestre_actual')->references('id')->on('semestre.semestre');
            $table->unsignedBigInteger('ubigeo_origen');
            $table->foreign('ubigeo_origen')->references('id')->on('general.ubigeo');
            $table->unsignedBigInteger('ubigeo_actual');
            $table->foreign('ubigeo_actual')->references('id')->on('general.ubigeo');
            $table->unsignedBigInteger('idtipo_documento_identidad');
            $table->foreign('idtipo_documento_identidad')->references('id')->on('general.tipo_documento_identidad');
            $table->string("numero_documento_identidad", 16);
            $table->date("fecha_emision_documento_identidad")->nullable();
            $table->unsignedBigInteger('idestado_civil');
            $table->foreign('idestado_civil')->references('id')->on('general.estado_civil');
            $table->unsignedBigInteger('idsexo');
            $table->foreign('idsexo')->references('id')->on('general.sexo');
            $table->string("nombres", 120);
            $table->string("apellido_paterno", 120);
            $table->string("apellido_materno", 120);
            $table->text("correo_institucional")->unique();
            $table->text("correo_personal")->unique()->nullable();
            $table->text("direccion");
            $table->text("telefono")->nullable();
            $table->date("fecha_nacimiento")->nullable();
            $table->string("nacionalidad", 80)->nullable();
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
        Schema::dropIfExists('general.persona');
    }
}
