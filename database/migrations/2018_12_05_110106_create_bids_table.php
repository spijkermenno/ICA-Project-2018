<?php

use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE bids (
                id        INT IDENTITY NOT NULL, -- Primary key
                item_id   INT NOT NULL, -- Verwijst naar de item waar op geboden is
                price     NUMERIC(7, 2) NOT NULL, -- Bied prijs
                user_name VARCHAR(20) NOT NULL, -- De gebruiker die geboden heeft
                date      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Tijdstip wanneer er een bod is geplaatst
            
                CONSTRAINT pk_bids PRIMARY KEY (id),
            
                CONSTRAINT fk_bids_item_id FOREIGN KEY (item_id) REFERENCES items (id),
                CONSTRAINT fk_bids_user_name FOREIGN KEY (user_name) REFERENCES users (name),
            
                CONSTRAINT chk_price CHECK(dbo.is_bid_allowed(price, item_id) = 1), -- Bod moet hoger zijn dan start prijs en hoogste bod
                CONSTRAINT chk_item_id CHECK(dbo.is_auction_closed(item_id) != 0), -- Bod kan niet worden geplaatst als de veiling gesloten is
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
            DROP TABLE bids
        ');
    }
}
