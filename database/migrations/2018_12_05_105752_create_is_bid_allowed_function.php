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
        $this->down();

        statement(
            'CREATE FUNCTION dbo.is_bid_allowed(@bid_price NUMERIC(7, 2), @item_id INT, @bid_id INT) RETURNS BIT
            BEGIN
            DECLARE @bid_to_beat NUMERIC(7, 2);
            DECLARE @end_date DATETIME;

            SELECT top 1 @bid_to_beat = CASE
                                            WHEN EXISTS(
                                                SELECT price
                                                FROM bids
                                                WHERE item_id = @item_id AND id != @bid_id
                                            )
                                            THEN (
                                            SELECT max(price)
                                            FROM bids
                                            WHERE item_id = @item_id AND id != @bid_id
                                            )
                                            ELSE (select start_price FROM items WHERE items.id = @item_id)
                END
            SELECT @end_date = [end] FROM items WHERE items.id = @item_id

            IF @bid_price > @bid_to_beat AND CURRENT_TIMESTAMP < @end_date
                RETURN 1

            RETURN 0
            END
        '
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        statement('
            IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N\'dbo.is_bid_allowed\')
            AND type in (N\'FN\', N\'IF\',N\'TF\', N\'FS\', N\'FT\'))
            DROP FUNCTION dbo.is_bid_allowed
        ');
    }
}
