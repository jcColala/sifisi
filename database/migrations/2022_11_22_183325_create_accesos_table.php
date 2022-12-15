<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.accesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idmodulo");
            $table->foreign('idmodulo')->references('id')->on('seguridad.modulo');
            $table->unsignedBigInteger("idrol");
            $table->foreign('idrol')->references('id')->on('seguridad.role');
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
        Schema::dropIfExists('seguridad.accesos');
    }
}
