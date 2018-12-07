<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE categories (
              id           INT                       NOT NULL, --App C: geen auto increment
              name         VARCHAR(45)               NOT NULL, --Zelfde lengte als de titel van een voorwerp
              parent       INT                       NULL, --NULL moet beschikbaar zijn, want root is NULL
              order_number INT                       NOT NULL, --App D: NOT NULL
              inactive     BIT DEFAULT 0             NOT NULL, --Uitfaseren 0 is false, 1 is true
            
              CONSTRAINT pk_categories PRIMARY KEY (id),
              CONSTRAINT fk_categories_parent FOREIGN KEY (parent) REFERENCES categories (id)
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DROP TABLE categories
        ');
    }
}
