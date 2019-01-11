<?php

use Illuminate\Database\Migrations\Migration;

class AddSentToPostalValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            ALTER TABLE postal_validations
                ADD sent BIT NOT NULL DEFAULT 0
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
