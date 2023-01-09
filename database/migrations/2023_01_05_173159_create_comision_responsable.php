<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionResponsable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones.comision_responsable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcomision');
            $table->foreign('idcomision')->references('id')->on('comisiones.comision');
            $table->unsignedBigInteger('idresponsable');
            $table->foreign('idresponsable')->references('id')->on('general.persona');
            $table->string("presidente", 1)->default('N')->comment('N --> Miembro , S --> Presidente');
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
        Schema::dropIfExists('comisiones.comision_responsable');
    }
}
