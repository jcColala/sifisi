<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloPadreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.modulo_padre', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion", 120);
            $table->string("abreviatura", 60);
            $table->text("url")->nullable();
            $table->string("icono", 60)->nullable();
            $table->integer("orden")->default(1);
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
        Schema::dropIfExists('seguridad.modulo_padre');
    }
}
