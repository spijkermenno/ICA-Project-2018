<?php

use Illuminate\Database\Migrations\Migration;

class AddUserNameToPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            ALTER TABLE password_resets
            ADD
                user_name VARCHAR(20) NOT NULL
            CONSTRAINT
                fk_password_resets_users_user_name FOREIGN KEY (user_name) REFERENCES users (name)
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
            ALTER TABLE password_resets
                DROP
                    CONSTRAINT fk_password_resets_users_user_name,
                    COLUMN user_name
        ');
    }
}
