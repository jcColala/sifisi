<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.modulo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idmodulo_padre");
            $table->foreign('idmodulo_padre')->references('id')->on('seguridad.modulo_padre');
            $table->unsignedBigInteger("idsistema")->nullable();
            $table->foreign('idsistema')->references('id')->on('sistemas.sistema');
            $table->integer("idpadre")->nullable();
            $table->string("modulo", 120);
            $table->string("abreviatura", 60)->nullable();
            $table->text("url")->nullable();
            $table->integer("orden")->default(1);
            $table->string("icono", 60)->nullable();
            $table->string("acceso_directo", 1)->default('N');
            $table->boolean("editable")->default(true);
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
        Schema::dropIfExists('seguridad.modulo');
    }
}
