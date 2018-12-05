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
        DB::statement('
            CREATE FUNCTION dbo.is_bid_allowed (@bid_price NUMERIC(7, 2), @item_id INT) RETURNS BIT
              BEGIN
                DECLARE @highest_bid NUMERIC(7, 2);
                DECLARE @starting_price NUMERIC(7, 2);
            
                SELECT @starting_price = start_price FROM items WHERE id = @item_id;
                SELECT @highest_bid = MAX(price) FROM bids where item_id = @item_id;
            
                IF @bid_price > @starting_price AND @bid_price > @highest_bid
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
