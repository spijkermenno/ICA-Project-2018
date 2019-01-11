<?php

use Illuminate\Database\Migrations\Migration;

class AlterBuyerOnItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            ALTER TABLE items DROP CONSTRAINT fk_items_buyer
        ');

        statement('
            ALTER TABLE 
                items
            DROP COLUMN 
                buyer
        ');

        statement('
            ALTER TABLE 
                items
            ADD 
                buyer AS dbo.item_buyer(items.id)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
