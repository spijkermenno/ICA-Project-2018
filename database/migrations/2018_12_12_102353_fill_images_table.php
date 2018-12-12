<?php

use Illuminate\Database\Migrations\Migration;

class FillImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource = fopen(database_path('csv/illustrations.csv'), 'r');

        while (($item = fgetcsv($resource, 0, ';', '\'')) !== false) {
            $item = [
                'item_id' => (int) intval($item[0]),
                'filename' => $item[1]
            ];

            statement('
                INSERT INTO images
                    (' . implode(',', array_keys($item)) . ')
                VALUES
                    (' . implode(',', array_map(function ($part) { return ':' . $part; }, array_keys($item))) . ')
            ', $item);
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
            DELETE FROM images
        ');
    }
}
