<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE users (
                name VARCHAR(20) NOT NULL,

                firstname VARCHAR(50) NOT NULL,
                lastname VARCHAR(50) NOT NULL,

                adress_line_1 VARCHAR(120) NOT NULL, --
                adress_line_2 VARCHAR(120) NULL, -- Line 2 is niet verplicht Appendix C -> Gebruikers

                postalcode VARCHAR(10), -- Internationale (post/zip)code kan max 10 characters lang zijn -> USA en Iran hebben 10 digits.
                city VARCHAR(100), -- Langste stad naam is 85 characters
                country VARCHAR(40), -- Lanste naam van een land is "Democratische Republiek Congo"

                birthday DATE NOT NULL,

                email VARCHAR(255) NOT NULL, -- Email kan maximaal 255 characters zijn -> https://tools.ietf.org/html/rfc3696

                password CHAR(60) NOT NULL, -- Bcrypt encrypted string heeft 60 bytes nodig (Unicode is niet nodig)

                secret_question_id INTEGER NOT NULL, -- Refereerd naar de secret_questions tabel
                secret_question_answer CHAR(60) NOT NULL, -- Bcrypt encrypted string heeft 60 bytes nodig (Unicode is niet nodig)

                seller BIT NOT NULL DEFAULT 0, -- Geeft aan of een gebruiker een verkoper is.

                CONSTRAINT pk_users PRIMARY KEY (name), -- Appendix C -> Gebruikers naam is de unieke identifier
                CONSTRAINT fk_users_secret_questions_secret_question_id FOREIGN KEY (secret_question_id) REFERENCES secret_questions (id),

                CONSTRAINT unq_users_email UNIQUE(email), -- Zorg er voor dat de email unique is zodat er geen accounts met dezelfe email aangemaakt kunnen worden.

                CONSTRAINT chk_users_name_length CHECK (LEN(name) > 6), -- Appendix B -> Gebruikersnaam moet minnimaal 7 characters zijn.
                CONSTRAINT chk_users_email_valid CHECK (email NOT LIKE \'%[^a-z-_.@]%\' -- Email kan alleen a-z _ . en @ bevatten
                AND LEN(email) - LEN(REPLACE(email,\'@\',\'\')) = 1) -- Email mag alleen 1 @ bevatten.
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
            DROP TABLE users
        ');
    }
}
