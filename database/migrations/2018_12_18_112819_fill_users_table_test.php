<?php

use Illuminate\Database\Migrations\Migration;

class FillUsersTableTest extends Migration
{
    public $users = [
        [
            'name' => 'Admin',
            'firstname' => 'Admin',
            'lastname' => 'EenmaalAndermaal',
            'adress_line_1' => 'Ruitenberglaan 26',
            'adress_line_2' => null,
            'postalcode' => '6826 CC',
            'city' => 'Arnhem',
            'country' => 'Nederland',
            'birthday' => '1970-01-01',
            'email' => 'admin@eenmaalandermaal.nl',
            'password' => '$2y$10$IsuBNdwaIg.Vg/1eK0dzSumtNr/kuSzmU9zJw/3ah7jUhDa0AoWNu',
            'secret_question_id' => 5,
            'secret_question_answer' => '$2y$10$RBcbgUbYo5dkC8c2Dvs1.O36C1J.TgPwZ3WHo2XkmIHGNg1eVrL4i',
            'seller' => 0,
            'admin' => 1
        ],
        [
            'name' => 'Verkoper',
            'firstname' => 'Verkoper',
            'lastname' => 'EenmaalAndermaal',
            'adress_line_1' => 'Ruitenberglaan 26',
            'adress_line_2' => null,
            'postalcode' => '6826 CC',
            'city' => 'Arnhem',
            'country' => 'Nederland',
            'birthday' => '1970-01-01',
            'email' => 'verkoper@eenmaalandermaal.nl',
            'password' => '$2y$10$C7pa6PntzQjcZhZNMIm3jOTrYAxcpu.9.nTme.fY0Z2VzqhqIPyGW',
            'secret_question_id' => 5,
            'secret_question_answer' => '$2y$10$swYaxpcdmdPZ9G1Bd5cmG.IgwgkZmkh94Ewtjn2EK0Ai1bICL7gfu',
            'seller' => 1,
            'admin' => 0
        ],
        [
            'name' => 'Gebruiker',
            'firstname' => 'Gebruiker',
            'lastname' => 'EenmaalAndermaal',
            'adress_line_1' => 'Ruitenberglaan 26',
            'adress_line_2' => null,
            'postalcode' => '6826 CC',
            'city' => 'Arnhem',
            'country' => 'Nederland',
            'birthday' => '1970-01-01',
            'email' => 'gebruiker@eenmaalandermaal.nl',
            'password' => '$2y$10$qlFbvMmN3op41SJjfaBPgu9fzIdnbTaAPwuKziEmSAqaSLt74a27S',
            'secret_question_id' => 5,
            'secret_question_answer' => '$2y$10$PDznjVAxN4KSnHkUeN8ej..AVbp.6ePy2XLzRj0tsgQ4NLzwdb9Ny',
            'seller' => 0,
            'admin' => 0
        ]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->users)->map(function ($row) {
            return (object)$row;
        })->each(function ($row) {
            $this->insertUser($row->name, $row->firstname, $row->lastname, $row->adress_line_1, $row->adress_line_2, $row->postalcode, $row->city, $row->country, $row->birthday, $row->email, $row->password, $row->secret_question_id, $row->secret_question_answer, $row->seller, $row->admin);
        });
    }

    public function insertUser($name, $firstname, $lastname, $adress_line_1, $adress_line_2, $postalcode, $city, $country, $birthday, $email, $password, $secret_question_id, $secret_question_answer, $seller, $admin)
    {
        return DB::statement('
            INSERT INTO users 
                (name, firstname, lastname, adress_line_1, adress_line_2, postalcode, city, country, birthday, email, password, secret_question_id, secret_question_answer, seller, admin) 
            VALUES 
                (:name, :firstname, :lastname, :adress_line_1, :adress_line_2, :postalcode, :city, :country, :birthday, :email, :password, :secret_question_id, :secret_question_answer, :seller, :admin);
        ', [
            'name' => $name,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'adress_line_1' => $adress_line_1,
            'adress_line_2' => $adress_line_2,
            'postalcode' => $postalcode,
            'city' => $city,
            'country' => $country,
            'birthday' => $birthday,
            'email' => $email,
            'password' => $password,
            'secret_question_id' => $secret_question_id,
            'secret_question_answer' => $secret_question_answer,
            'seller' => $seller,
            'admin' => $admin
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DELETE FROM users
        ');
    }
}
