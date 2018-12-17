<?php

use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE sellers (
                user_name VARCHAR(60) NOT NULL, -- Primary key

                verification_method VARCHAR(20) NOT NULL,
                bank VARCHAR(60) NOT NULL, -- niet echt duidelijk hoe lang de naam van een bank kan zijn in bijv. het buitenland of een nieuwe bank die nog komt

                iban CHAR(34) NOT NULL, -- max IBAN lengte is 34 characters

                -- Verificatie als deze Null is wordt de post methode gebruikt.
                creditcard BIGINT NULL, -- max credit card lengte is 16 nummers

                CONSTRAINT pk_sellers PRIMARY KEY (user_name),

                CONSTRAINT fk_sellers_verification_method FOREIGN KEY (verification_method)
                    REFERENCES seller_verification_methods (name),

                CONSTRAINT fk_sellers_user_name FOREIGN KEY (user_name)
                    REFERENCES users (name)
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
        statement('
            DROP TABLE sellers
        ');
    }
}
