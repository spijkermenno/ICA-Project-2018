<?php

use Illuminate\Database\Migrations\Migration;

class FillCategoriesTable extends Migration
{
    // public $withinTransaction = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource = fopen(__DIR__ . '/../csv/categories-2.csv', 'r');

        while (($category = fgetcsv($resource, 0, ';', '\'')) !== false) {
            DB::statement('
                INSERT INTO categories
                    (id, name, parent)
                VALUES
                    (:id, :name, NULL)
            ', [
                'id' => intval($category[0]) !== 0 ? intval($category[0]) : 1,
                'name' => $category[1]
            ]);
        }

        $resource = fopen(__DIR__ . '/../csv/categories-2.csv', 'r');

        while (($category = fgetcsv($resource, 0, ';', '\'')) !== false) {
            DB::statement('
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
        DB::statement('
            DELETE FROM categories
        ');
    }
}
