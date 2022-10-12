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
            $table->unsignedBigInteger("idperfil");
            $table->foreign('idperfil')->references('id')->on('seguridad.perfil');
            $table->integer("acceder")->default(0);
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
