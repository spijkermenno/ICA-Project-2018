<?php

use Illuminate\Database\Migrations\Migration;

class CreateIsUserSellerFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE FUNCTION dbo.is_user_seller(
                @user_name VARCHAR(60)
            ) RETURNS BIT
            BEGIN
            DECLARE @sellers INT;

            SELECT
                @sellers = COUNT(*)
            FROM sellers
            WHERE user_name = @user_name

            IF @sellers > 0
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
        statement('
            DROP FUNCTION dbo.is_user_seller
        ');
    }
}
