<?php

namespace App\Repositories;

use App\Repositories\Contracts\SellerRepository;

class DatabaseSellerRepository extends DatabaseRepository implements SellerRepository
{
    protected function createModelFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        return new Seller($data);
    }

    public function retrieveById(string $identifier, array $columns = ['*']) {
        return $this->createModelFromData(
            array_first(
                $this->conn->select('
                    SELECT
                        ' . implode(', ', $columns) . '
                    FROM sellers
                    WHERE ' . $this->getIdentifierName() . ' = :identifier
                ', [
                    'identifier' => $identifier
                ]),
                null
            )
        );
    }

    public function create(array $data): Seller {
        $keys = collect(array_keys($data));

        $this->conn->statement('
            INSERT INTO sellers
                (' . $keys->implode(', ') . ')
            VALUES
                (' . $keys->map(function ($key) { return ':' . $key; })->implode(', ') . ')
        ', $data);

        return $this->retrieveById(
            $data[$this->getIdentifierName()]
        );
    }

    public function getIdentifierName() {
        return 'user_name';
    }
}
