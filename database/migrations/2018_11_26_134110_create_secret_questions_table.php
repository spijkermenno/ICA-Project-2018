<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateSecretQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE secret_questions (
                id int IDENTITY NOT NULL,

                question VARCHAR(100) NOT NULL,

                CONSTRAINT pk_secret_questions PRIMARY KEY (id)
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DROP TABLE secret_questions
        ');
    }
}
