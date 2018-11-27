<?php

use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE items (
                  id                  INT IDENTITY  NOT NULL, -- App C genereert zelf
                  title               VARCHAR(45)   NOT NULL, -- Omdat martkplaats 60 heeft
                  description         VARCHAR(800)  NOT NULL,
                  start_price         NUMERIC(7, 2) NOT NULL, -- Bedragen tot 100mjn
                  selling_price       NUMERIC(7, 2) NOT NULL DEFAULT \'Bank/Giro\',
                  payment_method      VARCHAR(20)   NOT NULL,
                  payment_instruction VARCHAR(20),
                  duration            TINYINT       NOT NULL DEFAULT 7,
                  "start"             DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  "end"                                      AS DATEADD(DAY, duration, start),
                  auction_closed                             AS (
                    CASE
                    WHEN GETDATE() > DATEADD(DAY, duration, start)
                      THEN 1
                    ELSE 0
                    END
                  ),
                  shipping_cost       NUMERIC(3, 2) NOT NULL,
                  seller              VARCHAR(20)   NOT NULL,
                  buyer               VARCHAR(20),
                  CONSTRAINT pk_items PRIMARY KEY (id),
                  CONSTRAINT fk_items_payment_method FOREIGN KEY (payment_method) REFERENCES payment_methods (name),
                  CONSTRAINT fk_items_seller FOREIGN KEY (seller) REFERENCES users (name),
                  CONSTRAINT fk_items_buyer FOREIGN KEY (buyer) REFERENCES users (name),
                  CONSTRAINT chk_title CHECK (LEN(RTRIM(LTRIM(title))) > 4),
                  CONSTRAINT chk_start_price CHECK (start_price > 1.00),
                  CONSTRAINT chk_duration CHECK (duration IN (1, 3, 5, 7, 10))
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
            DROP TABLE items
        ');
    }
}
