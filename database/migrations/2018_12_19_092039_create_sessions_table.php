<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE sessions (
                id VARCHAR(255) NOT NULL,
                user_id INT NULL,
                ip_address VARCHAR(45) NULL,
                user_agent VARCHAR(max) NULL,
                payload VARCHAR(max) NOT NULL,
                last_activity INT NOT NULL
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
        statement('
            DROP TABLE sessions
        ');
    }
}
