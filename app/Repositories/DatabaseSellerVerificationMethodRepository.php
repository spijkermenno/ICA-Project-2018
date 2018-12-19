<?php

namespace App\Repositories;

use App\SellerVerificationMethod;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class DatabaseSellerVerificationMethodRepository extends DatabaseRepository implements SellerVerificationMethodRepository
{
    public function getAll($columns = ['*'])
    {
        return collect(
            $this->conn->select('
                select
                    ' . implode(',', $columns) . '
                from seller_verification_methods
            ')
        )->mapInto(SellerVerificationMethod::class);
    }
}
