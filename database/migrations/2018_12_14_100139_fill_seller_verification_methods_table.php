<?php

use Illuminate\Database\Migrations\Migration;

class FillSellerVerificationMethodsTable extends Migration
{
    protected $methods = [
        'creditcard',
        'post'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->methods)->map(function ($method) {
            statement('
                INSERT INTO seller_verification_methods
                    (name)
                VALUES
                    (:name)
            ', [
                'name' => $method
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
        statement('
            DELETE FROM seller_verification_methods
        ');
    }
}
