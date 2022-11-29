<?php

use Illuminate\Database\Migrations\Migration;
use App\Actions\PGSchema;

class CreateSchemaGeneral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PGSchema)->create("general");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new PGSchema)->drop("general");
    }
}
