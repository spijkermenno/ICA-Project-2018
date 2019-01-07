<?php

use Illuminate\Database\Migrations\Migration;

class FillCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource = fopen(database_path('csv/categories_sprint3.csv'), 'r');

        while (($category = fgetcsv($resource, 0, ';', '\'')) !== false) {
            statement('
                INSERT INTO categories
                    (id, name, parent, order_number)
                VALUES
                    (:id, :name, NULL, :order_number)
            ', [
                'id' => intval($category[0]) !== 0 ? intval($category[0]) : 1,
                'name' => stripslashes($category[1]),
                'order_number' => intval($category[3])
            ]);
        }

        $resource = fopen(database_path('csv/categories_sprint3.csv'), 'r');

        while (($category = fgetcsv($resource, 0, ';', '\'')) !== false) {
            statement('
                UPDATE categories
                    SET parent = :parent
                WHERE id = :id
            ', [
                'id' => intval($category[0]) !== 0 ? intval($category[0]) : 1,
                'parent' => $category[2] == 'NULL' ? null : intval($category[2])
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
            DELETE FROM categories
        ');
    }
}
