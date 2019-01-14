<?php

use Illuminate\Database\Migrations\Migration;

class CreateSellerVerificationMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE seller_verification_methods (
                name   VARCHAR(20) NOT NULL, -- Primary key

                CONSTRAINT pk_seller_verification_methods PRIMARY KEY (name)
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
            DROP TABLE seller_verification_methods
        ');
    }
}
