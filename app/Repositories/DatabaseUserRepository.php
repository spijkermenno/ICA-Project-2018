<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;

class DatabaseUserRepository implements UserRepository
{
    protected $hasher;

    public function __construct(ConnectionInterface $conn, HasherContract $hasher)
    {
        parent::__construct($conn);

        $this->hasher = $hasher;
    }

    public function retrieveById($identifier)
    {
        dd(
            $this->con->select('
                select
                    *
                from users
                where
                    name = :identifier
            ', [
                'identifier' => $identifier
            ])
        );
    }
}