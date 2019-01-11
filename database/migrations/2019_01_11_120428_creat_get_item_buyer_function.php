<?php

use Illuminate\Database\Migrations\Migration;

class CreatGetItemBuyerFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        statement(
            'CREATE FUNCTION item_buyer(@item_id BIGINT) RETURNS VARCHAR(60)
            BEGIN
            declare @ff varchar(max);select
            TOP 1 @ff = user_name
            FROM
            bids
            WHERE
            item_id = @item_id
            ORDER BY price DESC
            RETURN @ff
            END'
            );
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        statement('
            IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N\'dbo.item_buyer\')
            AND type in (N\'FN\', N\'IF\',N\'TF\', N\'FS\', N\'FT\'))
            DROP FUNCTION dbo.item_buyer
        ');
    }
}
