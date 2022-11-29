<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbigeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.ubigeo', function (Blueprint $table) {
            $table->id();
            $table->string("cod_dpto", 2);
            $table->string("cod_prov", 2);
            $table->string("cod_dist", 2);
            $table->string("codccpp", 4);
            $table->string("nombre", 200);
            $table->string("reniec", 10);
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
        Schema::dropIfExists('general.ubigeo');
    }
}
