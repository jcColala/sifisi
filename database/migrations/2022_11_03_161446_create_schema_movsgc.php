<?php

use Illuminate\Database\Migrations\Migration;
use App\Actions\PGSchema;

class CreateSchemaMovsgc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PGSchema)->create("movsgc");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new PGSchema)->drop("movsgc");
    }
}
