<?php

use Illuminate\Database\Migrations\Migration;

class FillUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource = fopen(database_path('csv/users.csv'), 'r');
        $i = 0;

        while (($user = fgetcsv($resource, 0, ';', '\'')) !== false) {
            if (DB::select('
                SELECT
                    COUNT(*) as count
                FROM users
                WHERE name = :name
            ', [
                'name' => $user[0]
            ])[0]->count > 0) {
                continue;
            }

            statement('
                INSERT INTO users
                    (name, firstname, lastname, adress_line_1, postalcode, city, country, birthday, email, password, secret_question_id, secret_question_answer, seller)
                VALUES
                    (:name, :firstname, :lastname, :adress_line_1, :postalcode, :city, :country, :birthday, :email, :password, :secret_question_id, :secret_question_answer, :seller)
            ', [
                'name' => $user[0],
                'firstname' => $user[1],
                'lastname' => $user[2],

                'adress_line_1' => $user[3],
                'postalcode' => $user[4],
                'city' => $user[5],
                'country' => $user[6],

                'birthday' => $user[7],

                'email' => $user[8],
                'password' => $user[9],

                'secret_question_id' => $user[10],
                'secret_question_answer' => $user[11],

                'seller' => $user[12],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        statement('
            DELETE FROM users
        ');
    }
}
