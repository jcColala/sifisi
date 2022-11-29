<?php

use Illuminate\Database\Migrations\Migration;
use App\Actions\PGSchema;

class CreateSchemaSemestre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PGSchema)->create("semestre");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new PGSchema)->drop("semestre");
    }
}
