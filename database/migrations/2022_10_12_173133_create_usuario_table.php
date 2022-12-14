<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad.usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idpersona");
            $table->foreign('idpersona')->references('id')->on('general.persona');
            $table->unsignedBigInteger("idrol")->nullable();
            $table->foreign('idrol')->references('id')->on('seguridad.role');
            $table->string("usuario", 60);
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string("avatar", 60)->nullable();
            $table->string("es_superusuario", 1)->default("N");
            $table->integer("tema")->default(1)->comment("1 : TEMA NORMAL , 2 : TEMA OSUCRO ");
            $table->boolean("editable")->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('seguridad.usuario');
    }
}
