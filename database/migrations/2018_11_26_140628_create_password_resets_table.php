<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE password_resets (
                id int IDENTITY NOT NULL,

                email VARCHAR(255) NOT NULL,

                token CHAR(60) NOT NULL, -- Bcrypt encrypted string heeft 60 bytes nodig (Unicode is niet nodig)

                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                expired AS (CASE WHEN (CURRENT_TIMESTAMP < DATEADD(HOUR, 4, created_at)) THEN 0 ELSE 1 END), -- reset is expired na 4 uur

                CONSTRAINT pk_password_resets PRIMARY KEY (id)
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
            DROP TABLE password_resets
        ');
    }
}
