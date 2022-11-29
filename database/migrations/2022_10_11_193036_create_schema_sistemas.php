<?php

use Illuminate\Database\Migrations\Migration;
use App\Actions\PGSchema;

class CreateSchemaSistemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PGSchema)->create("sistemas");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new PGSchema)->drop("sistemas");
    }
}
