<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idestado')->default(1);
            $table->foreign('idestado')->references('id')->on('sgc.estado');

            $table->unsignedInteger('idpersona_solicita');
            $table->foreign('idpersona_solicita')->references('id')->on('general.persona');

            $table->unsignedInteger('idpersona_aprueba')->nullable();
            $table->foreign('idpersona_aprueba')->references('id')->on('general.persona');

            $table->unsignedBigInteger('idtipo_accion')->default(1);
            $table->foreign('idtipo_accion')->references('id')->on('sgc.tipo_accion');

            $table->unsignedBigInteger('idtipo_documento');
            $table->foreign('idtipo_documento')->references('id')->on('sgc.tipo_documentos');

            $table->unsignedBigInteger('identidad');
            $table->foreign('identidad')->references('id')->on('comisiones.cargo');

            $table->unsignedBigInteger('idresolucion');
            $table->foreign('idresolucion')->references('id')->on('sgc.resoluciones');

            $table->unsignedBigInteger('idtipo_archivo');
            $table->foreign('idtipo_archivo')->references('id')->on('sgc.tipo_archivos');

            $table->string('codigo', 120);
            $table->string('descripcion', 255);
            $table->date('fecha_emision');
            $table->date('fecha_aprobacion');
            $table->string('ubicacion_fisica');
            $table->float('version');
            $table->text('documento');
            $table->integer('porcentaje');
            $table->boolean('editable')->default(true);

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
        Schema::dropIfExists('sgc.documentos');
    }
}
