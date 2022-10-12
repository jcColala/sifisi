<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultad.facultad', function (Blueprint $table) {
            $table->id();
            $table->string("facultad", 120);
            $table->string("abreviatura", 60)->nullable();
            $table->text("vision")->nullable();
            $table->text("mision")->nullable();
            $table->text("valores")->nullable();
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
        Schema::dropIfExists('facultad.facultad');
    }
}
