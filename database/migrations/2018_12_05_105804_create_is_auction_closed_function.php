<?php

use Illuminate\Database\Migrations\Migration;

class CreateIsAuctionClosedFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE FUNCTION dbo.is_auction_closed (@item_id BIGINT) RETURNS BIT
                AS BEGIN RETURN (
                    SELECT auction_closed FROM items where id = @item_id
                )
            END;
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
            DROP FUNCTION dbo.is_auction_closed
        ');
    }
}
