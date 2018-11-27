<?php

namespace App\Repositories;

abstract class DatabaseRepository
{
    protected $conn;

    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }
}
