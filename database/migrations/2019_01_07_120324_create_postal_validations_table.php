<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostalValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE postal_validations (
                user_name VARCHAR(60) NOT NULL, -- Primary key

                token CHAR(60) NOT NULL, -- Bcrypt encrypted string heeft 60 bytes nodig (Unicode is niet nodig)

                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP

                CONSTRAINT pk_postal_validations PRIMARY KEY (user_name),

                CONSTRAINT fk_postal_validations_user_name FOREIGN KEY (user_name)
                    REFERENCES users (name)
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
            DROP TABLE postal_validations
        ');
    }
}
