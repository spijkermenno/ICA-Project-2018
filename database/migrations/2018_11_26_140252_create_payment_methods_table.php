<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        statement('
            CREATE TABLE payment_methods (
                name  VARCHAR(20) NOT NULL,

                CONSTRAINT pk_payment_method PRIMARY KEY (name)
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
            DROP TABLE payment_methods
        ');
    }
}
