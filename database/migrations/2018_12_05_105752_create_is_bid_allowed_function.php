<?php

use Illuminate\Database\Migrations\Migration;

class CreateIsBidAllowedFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE FUNCTION dbo.is_bid_allowed(@bid_price NUMERIC(7, 2), @item_id INT, @end_date DATE) RETURNS BIT
            BEGIN
            DECLARE @bid_to_beat NUMERIC(7, 2);
            
            SELECT top 1 @bid_to_beat = CASE
                                            WHEN EXISTS(
                                                SELECT price
                                                FROM bids
                                                WHERE item_id = @item_id
                                            )
                                            THEN (
                                            SELECT max(price)
                                            FROM bids
                                            WHERE item_id = @item_id
                                            )
                                            ELSE (select start_price FROM items WHERE items.id = @item_id)
                END
            
            IF @bid_price > @bid_to_beat AND getdate() <= @end_date
                RETURN 1
            
            RETURN 0
            END         
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
            DROP FUNCTION dbo.is_bid_allowed
        ');
    }
}
