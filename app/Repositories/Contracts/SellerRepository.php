<?php

namespace App\Repositories\Contracts;

interface SellerRepository
{
    public function retrieveById(string $identifier, array $columns);

    public function create();
}
