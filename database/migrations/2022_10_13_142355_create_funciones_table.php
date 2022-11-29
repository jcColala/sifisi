<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.funcion', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 120);
            $table->string("funcion", 120);
            $table->string("clase", 120)->nullable();
            $table->string("icono", 60)->nullable();
            $table->integer("orden")->nullable();
            $table->string("mostrar", 1)->default('N');
            $table->string("boton", 1)->default('N');
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
        Schema::dropIfExists('seguridad.funcion');
    }
}
