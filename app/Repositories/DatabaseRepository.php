<?php

namespace App\Repositories;

use Illuminate\Database\ConnectionInterface;

abstract class DatabaseRepository
{
    protected $conn;

    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }
}
