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
        // $this->tableIdentities();

        $this->convertInChunks(
            database_path('csv/items.csv'),
            100,
            'Items',
            function ($offset, $limit) {
                return $this->conn()->select('
                    SELECT
                        ID as id,
                        Titel as title,
                        Valuta as currency,
                        Beschrijving as description,
                        Verkoper as seller,
                        Prijs as selling_price,
                        Categorie as category,
                        Locatie as country
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
                    'description' => base64_encode($item->description),

                    'start_price' => $this->convertToEUR(
                        $item->currency,
                        $item->selling_price
                    ),
                    'selling_price' => $this->convertToEUR(
                        $item->currency,
                        $item->selling_price
                    ),

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
                    'start' => Carbon::instance($this->faker->dateTimeBetween(
                        Carbon::today(),
                        Carbon::today()->addWeeks(2)
                    ))->toDateTimeString(),

                    'shipping_cost' => $this->faker->randomNumber(2),
                    'seller' => $item->seller,
                    'category' => $item->category,
                    'country' => $item->country,
                    'city' => $this->faker->city()
                ];
            }
        );
    }

    // protected function tableIdentities()
    // {
    //     collect([
    //         '
    //             ALTER TABLE Items
    //             ADD old_id BIGINT NULL
    //         ',
    //         '
    //             UPDATE Items
    //                 SET Items.old_id = (
    //                     SELECT ID
    //                     FROM Items as old_items
    //                     WHERE Items.id = old_items.id
    //                 )
    //         ',
    //         '
    //             ALTER TABLE Items
    //                 DROP CONSTRAINT PK_items
    //         ',
    //         '
    //             ALTER TABLE Items
    //                 DROP COLUMN ID
    //         ',
    //         '
    //             ALTER TABLE Items
    //                 ADD ID BIGINT IDENTITY NOT NULL
    //         ',
    //         '
    //             ALTER TABLE Illustraties
    //                 DROP CONSTRAINT ItemsVoorPlaatje
    //         ',
    //         '
    //             UPDATE Illustraties
    //                 SET Illustraties.ItemID = (
    //                     SELECT ID
    //                     from items
    //                     WHERE items.old_id = Illustraties.ItemID
    //                 )
    //         ',
    //         '
    //             ALTER TABLE Items
    //                 DROP COLUMN old_id
    //         ',
    //         '
    //             ALTER TABLE Items
    //                 ADD CONSTRAINT PK_Items PRIMARY KEY (ID)
    //         ',
    //         '
    //             ALTER TABLE Illustraties
    //                 ADD CONSTRAINT ItemsVoorPlaatje FOREIGN KEY (ItemID) REFERENCES Items(ID)
    //         '
    //     ])->map(function ($statement) {
    //         $this->conn()
    //             ->statement($statement);
    //     });
    // }
}
