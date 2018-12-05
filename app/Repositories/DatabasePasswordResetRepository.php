<?php

namespace App\Repositories;

use App\PasswordReset;
use Illuminate\Database\ConnectionInterface;
use App\Repositories\Contracts\PasswordResetRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class DatabasePasswordResetRepository extends DatabaseRepository implements PasswordResetRepository
{
    public function __construct(
        ConnectionInterface $conn,
        HasherContract $hasher
    ) {
        parent::__construct($conn);

        $this->hasher = $hasher;
    }

    protected function createModelFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        return new PasswordReset($data);
    }

    public function validateCredentials(PasswordReset $reset, array $credentials): bool
    {
        return $this->hasher->check(
            $credentials['token'] ?? '',
            $reset->token
        );
    }

    public function getByUserEmail($email)
    {
        return $this->createModelFromData(
            array_first(
                $this->conn->select('
                    SELECT TOP 1
                        *
                    FROM password_resets
                    WHERE email = :email
                    ORDER BY created_at DESC
                ', [
                    'email' => $email
                ]),
                null
            )
        );
    }

    public function createTokenForUserEmail($email): string
    {
        $token = str_random(32); // max bcrypt string is 72

        $this->conn->statement('
            INSERT INTO password_resets
                (email, token)
            VALUES
                (:email, :token)
        ', [
            'email' => $email,
            'token' => $this->hasher->make($token)
        ]);

        return $token;
    }
}
