<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoceroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgc.proceso_cero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idtipo_proceso');
            $table->string('descripcion', 120);
            $table->string('abrev', 20)->unique();
            $table->float('version', 10);
            $table->string('responsable', 120);// ESTO DEBE SER FK 
            $table->text('objetivo');
            $table->text('alcance');
            $table->text('proveedores');
            $table->text('entradas');
            $table->text('salidas');
            $table->text('clientes');
            $table->text('nombre_elaborado');//DEBE SER FK
            $table->text('nombre_revisado');//DEBE SER FK
            $table->text('nombre_aprobado');//DEBE SER FK
            $table->text('cargo_elaborado');//DEBE SER FK
            $table->text('cargo_revisado');//DEBE SER FK
            $table->text('cargo_aprobado');//DEBE SER FK
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idtipo_proceso')->references('id')->on('sgc.tipo_proceso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proceso_cero');
    }
}
