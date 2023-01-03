<?php

use Illuminate\Database\Migrations\Migration;
use App\Actions\PGSchema;

class CreateSchemaComisiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PGSchema)->create("comisiones");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new PGSchema)->drop("comisiones");
    }
}
