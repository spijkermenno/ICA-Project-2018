<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\ConnectionInterface;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\Contracts\PasswordResetRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class DatabaseUserRepository extends DatabaseRepository implements UserRepository
{
    protected $hasher;
    protected $passwordResetRepository;

    public function __construct(
        ConnectionInterface $conn,
        HasherContract $hasher,
        PasswordResetRepository $passwordResetRepository
    ) {
        parent::__construct($conn);

        $this->hasher = $hasher;

        $this->passwordResetRepository = $passwordResetRepository;
    }

    protected function createAuthenticableFromData($data)
    {
        if (empty($data)) {
            return null;
        }
        return new User($data);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->createAuthenticableFromData(
            array_first(
                $this->conn->select('
                    select top 1
                        *
                    from users
                    where
                        name = :identifier
                ', [
                    'identifier' => $identifier
                ]),
                null
            )
        );
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return $this->retrieveById($identifier);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->retrieveById($credentials['name'] ?? '');
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return $this->hasher->check(
            $credentials['password'] ?? '',
            $user->getAuthPassword()
        );
    }
}
