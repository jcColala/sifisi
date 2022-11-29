<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultad.escuela', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idfacultad');
            $table->foreign('idfacultad')->references('id')->on('facultad.facultad');
            $table->string("escuela", 120);
            $table->string("abreviatura", 60)->nullable();
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
        Schema::dropIfExists('facultad.escuela');
    }
}
