<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertUsers extends DataConverter
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = $this->conn->select('
            select
                Username as name,
                Postalcode as postalcode,
                Location as country
            from Users
        ');

        $this->convert($users, database_path('csv/users.csv'), function ($user) {
            return [
                'name' => $user->name,
                'firstname' => $this->faker->firstName,
                'lastname' => $this->faker->lastName,

                'adress_line_1' => $this->faker->streetAddress,
                'postalcode' => $user->postalcode,
                'city' => $this->faker->city,
                'country' => $user->country,

                'birthday' => $this->faker->dateTimeThisCentury->format('Y-m-d'),

                'email' => $this->faker->email,
                'password' => $this->hasher->make($this->faker->password),

                'secret_question_id' => $this->faker->numberBetween(1, 5),
                'secret_question_answer' => $this->hasher->make($this->faker->password),

                'seller' => 1
            ];
        });
    }
}
