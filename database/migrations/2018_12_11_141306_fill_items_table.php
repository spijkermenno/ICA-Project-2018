<?php

use Illuminate\Database\Migrations\Migration;

class FillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource = fopen(database_path('csv/items.csv'), 'r');

        statement('
            SET IDENTITY_INSERT dbo.items ON;
        ');

        while (($item = fgetcsv($resource, 0, ';', '\'')) !== false) {
            $item = [
                'id' => (int) intval($item[0]),
                'title' => $item[1],
                'description' => $item[2],

                'start_price' => floatval($item[3]) <= 1 ? 1.1 : floatval($item[3]),
                'selling_price' => floatval($item[4]),

                'payment_method' => $item[5],
                'payment_instruction' => $item[6],

                'duration' => intval($item[7]),
                'start' => $item[8],

                'shipping_cost' => floatval($item[9]),
                'seller' => $item[10],
                'category_id' => intval($item[11])
            ];

            statement('
                SET IDENTITY_INSERT dbo.items ON;
                INSERT INTO items
                    (' . implode(',', array_keys($item)) . ')
                VALUES
                    (' . implode(',', array_map(function ($part) { return ':' . $part; }, array_keys($item))) . ')
            ', $item);
        }

        statement('
            SET IDENTITY_INSERT dbo.items OFF;
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
            DELETE FROM items
        ');
    }
}
