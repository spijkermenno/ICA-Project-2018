<?php

namespace App\Repositories;

class DatabasePaymentMethodRepository extends DatabaseRepository
{
    public function getAll()
    {
        return $this->conn->select('
            SELECT name FROM payment_methods 
            ORDER BY name ASC');
    }

    public function getById($name)
    {
        return $this->conn->select(
            '
             SELECT name FROM payment_methods 
             WHERE name = ?',
            [$name]
        );
    }
}
