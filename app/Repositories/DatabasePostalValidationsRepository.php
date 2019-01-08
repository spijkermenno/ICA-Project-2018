<?php

namespace App\Repositories;

use App\User;
use App\PostalValidation;
use App\Repositories\Contracts\PostalValidationsRepository;

class DatabasePostalValidationsRepository extends DatabaseRepository implements PostalValidationsRepository
{
    protected function createModelFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        return new PostalValidation($data);
    }

    public function validateCredentials(PostalValidation $validation, array $credentials): bool
    {
        return trim($credentials['token'])
            == trim($validation->token);
    }

    public function getByUser(User $user)
    {
        return $this->createModelFromData(
            array_first(
                $this->conn->select('
                    SELECT TOP 1
                        *
                    FROM postal_validations
                    WHERE user_name = :user_name
                    ORDER BY created_at DESC
                ', [
                    $this->getIdentifierName() => $user->getAuthIdentifier()
                ]),
                null
            )
        );
    }

    public function createTokenForUser(User $user): string
    {
        $token = str_random(32); // max bcrypt string is 72

        $this->conn->statement('
            INSERT INTO postal_validations
                (user_name, token)
            VALUES
                (:user_name, :token)
        ', [
            $this->getIdentifierName() => $user->getAuthIdentifier(),
            'token' => $token
        ]);

        return $token;
    }

    public function removeByUser(User $user)
    {
        return $this->conn->statement('
            DELETE FROM postal_validations
            WHERE user_name = :user_name
        ', [
            $this->getIdentifierName() => $user->getAuthIdentifier()
        ]);
    }

    public function getIdentifierName()
    {
        return 'user_name';
    }
}
