<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.roles_accesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idroles");
            $table->foreign('idroles')->references('id')->on('seguridad.roles');
            $table->unsignedBigInteger("idaccesos");
            $table->foreign('idaccesos')->references('id')->on('seguridad.accesos');
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
        Schema::dropIfExists('seguridad.roles_accesos');
    }
}
