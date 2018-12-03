<?php

use Illuminate\Database\Migrations\Migration;

class FillCategoriesTable extends Migration
{
    public $withinTransaction = false;

    public

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        dump('test');

        dump(DB::statement('
            INSERT INTO categories
                (id, name, parent)
            VALUES
                (-1, \'Root\', NULL)
        '));

        dump('test2');

        // collect($parents)
        //     ->pipe(function ($parents) {
        //         $children = collect($this->categoryRepository->getChildrenFor($parents->pluck('id')))
        //             ->groupBy('parent');

        //         $parents->map(function ($parent) use ($children) {
        //             $parent->children = $children[$parent->id];

        //             return $parent;
        //         });
        //     });

        // $parent->children as $child

        // DB::beginTransaction();

        $resource = fopen(__DIR__ . '/../csv/categories.csv', 'r');

        while (($category = fgetcsv($resource, 0, ';')) !== false) {
            dump([
                [$category[0], (int) ($category[0])],
                $category[1],
                intval($category[2])
            ]);
            try {
                DB::statement('
                    INSERT INTO categories
                        (id, name, parent)
                    VALUES
                        (?, ?, ?)
                ', [
                    intval($category[0]) !== 0 ? intval($category[0]) : 1,
                    $category[1],
                    intval($category[2])
                ]);

                DB::commit();
            } catch (Exception $e) {
                dd($e);
            }
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
