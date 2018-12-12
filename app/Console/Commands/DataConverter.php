<?php

namespace App\Console\Commands;

use Closure;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

abstract class DataConverter extends Command
{
    protected $hasher;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        HasherContract $hasher
    ) {
        parent::__construct();

        $this->conn = DB::connection('tmp_sqlsrv');

        $this->faker = Faker::create();

        $this->hasher = $hasher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->conn = DB::connection('sqlsrv');

        $this->items();
    }

    protected function convert($data, $file, Closure $callback, $progress = true)
    {
        $resource = is_resource($file);

        $bar = $this->output->createProgressBar(count($data));

        if ($progress) {
            $bar->start();
        }

        if (!$resource) {
            $file = fopen($file, 'c+');
        }

        collect($data)->each(function ($row) use ($file, $bar, $callback, $progress) {
            if ($progress) {
                $bar->advance();
            }

            fputcsv($file, $callback($row), ';', '\'');
        });

        if (!$resource) {
            fclose($file);
        }

        if ($progress) {
            $bar->finish();
        }
    }

    protected function convertInChunks($file, $amount, $table, Closure $query, Closure $callback)
    {
        $count = $this->conn->select('
            SELECT
                COUNT(*) as count
            FROM ' . $table . '
        ')[0]->count;

        $file = fopen($file, 'c+');

        $bar = $this->output->createProgressBar(ceil($count / $amount));

        $bar->start();

        collect(
            range(0, ceil($count / $amount))
        )->each(function ($number) use ($bar, $file, $amount, $query, $callback) {
            $bar->advance();

            $this->convert(
                $query($amount * $number, $amount),
                $file,
                $callback
            );
        });

        $bar->finish();

        fclose($file);
    }

    protected function users()
    {
        $users = $this->tmpDB->select('
            select
                Username as name,
                Postalcode as postalcode,
                Location as country
            from Users
        ');

        $this->convert($users, './users.csv', function ($user) {
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

    protected function items()
    {
        $this->info('Query');

        $this->convertInChunks(
            './items.csv',
            100,
            'Items',
            function ($offset, $limit) {
                return $this->tmpDB->select('
                    SELECT
                        ID as id,
                        Titel as title,
                        Beschrijving as description,
                        Verkoper as seller,
                        Prijs as selling_price
                    FROM Items
                    ORDER BY ID
                    OFFSET ' . $offset . ' ROWS
                    FETCH NEXT ' . $limit . ' ROWS ONLY
                ');
            },
            function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,

                    'start_price' => 0.0,
                    'selling_price' => $item->selling_price,

                    'payment_method' => $this->faker->randomElement([
                        'Bank/Giro',
                        'Creditcard'
                    ]),
                    'payment_instruction' => $this->faker->randomElement([
                        'Bank/Giro',
                        'Creditcard'
                    ]),

                    'duration' => $this->faker->randomElement([
                        1, 3, 5, 7, 10
                    ]),
                    'start' => $this->faker->dateTimeBetween(
                        Carbon::today(),
                        Carbon::today()->addMonths(3)
                    )->format('Y-m-d'),

                    'shipping_cost' => $this->faker->randomNumber(2),
                    'seller' => $item->seller
                ];
            }
        );
    }
}
