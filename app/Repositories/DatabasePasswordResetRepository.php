<?php

namespace App\Repositories;

use App\Repositories\Contracts\PasswordResetRepository;

class DatabasePasswordResetRepository extends DatabaseRepository implements PasswordResetRepository
{
    protected function createModelFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        return new PasswordReset($data);
    }

    public function getByUserIdentifier($identifier)
    {
        return $this->createModelFromData(
            array_first(
                $this->conn->select('
                    SELECT TOP 1
                        *
                    FROM password_resets
                    WHERE user_name = :identifier
                ', [
                    'identifier' => $identifier
                ]),
                null
            )
        );
    }

    public function updateTokenByUserIdentifier($identifier, $token): bool
    {
        return $this->conn->update('
            UPDATE password_resets
                SET token = :token
            WHERE user_name = :identifier
        ', [
            'token' => $token,
            'identifier' => $identifier
        ]);
    }
}
