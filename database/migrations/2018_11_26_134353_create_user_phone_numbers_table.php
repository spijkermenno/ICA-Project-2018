<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE user_phone_numbers (
                number tinyint NOT NULL,
                user_name VARCHAR(40) NOT NULL,
                phone_number VARCHAR(15) -- E.164 nummers mogen niet langer zijn dan 15 characters

                CONSTRAINT pk_user_phone_numbers PRIMARY KEY (number,
                    user_name),
                CONSTRAINT fk_user_phone_numbers_user_name FOREIGN KEY (user_name) REFERENCES users (name),

                CONSTRAINT chk_phone_number_valid_rgxp CHECK (LEN(phone_number) > 7) -- Valide telefoonummer moet minimaal 8 karacters zijn
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
            DROP TABLE user_phone_numbers
        ');
    }
}
