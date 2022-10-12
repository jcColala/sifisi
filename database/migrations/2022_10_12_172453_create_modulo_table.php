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
            $table->integer("idpadre")->nullable();
            $table->string("modulo", 120);
            $table->string("abreviatura", 60);
            $table->text("url")->nullable();
            $table->integer("orden")->default(1);
            $table->string("icono", 60);
            $table->string("acceso_directo", 1)->default('N');
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
