<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones.comision', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcreador');
            $table->foreign('idcreador')->references('id')->on('general.persona');
            $table->string("descripcion", 120);
            $table->string("abreviatura", 60)->nullable();
            $table->string("resolucion", 60);
            $table->string("especiales", 1)->default('N')->comment('N --> Comisiones permanentes , S --> Comisiones especiales');
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->string("anio", 5);
            $table->string("mes", 3);
            $table->boolean('editable')->default(true);
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
        Schema::dropIfExists('comisiones.comision');
    }
}
