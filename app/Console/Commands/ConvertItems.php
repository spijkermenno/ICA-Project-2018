<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class ConvertItems extends DataConverter
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:items';

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
        $this->convertInChunks(
            database_path('csv/items.csv'),
            100,
            'Items',
            function ($offset, $limit) {
                return $this->conn()->select('
                    SELECT
                        ID as id,
                        Titel as title,
                        Beschrijving as description,
                        Verkoper as seller,
                        Prijs as selling_price,
                        Categorie as category
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
                    'seller' => $item->seller,
                    'category' => $item->category
                ];
            }
        );
    }
}
