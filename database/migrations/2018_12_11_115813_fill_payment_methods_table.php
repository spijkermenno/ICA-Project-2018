<?php

use Illuminate\Database\Migrations\Migration;

class FillPaymentMethodsTable extends Migration
{
    protected $paymentMethods = [
        'Bank/Giro',
        'Creditcard'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->paymentMethods)->map(function ($method) {
            statement('
                INSERT INTO payment_methods (name) VALUES (:method)
            ', [
                'method' => $method
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
