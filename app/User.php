<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\Contracts\PasswordResetRepository;

class User extends ORMLessModel implements Authenticatable
{
    protected $passwordResetRepository;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->passwordResetRepository = app()->make(PasswordResetRepository::class);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'name';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->offsetGet($this->getAuthIdentifierName());
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->offsetGet('password');
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->passwordResetRepository->updateTokenByUserIdentifier(
            $this->offsetGet($this->getAuthIdentifierName()),
            $token
        )[$this->getRememberTokenName()];
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($token)
    {
        return $this->passwordResetRepository->updateTokenByUserIdentifier(
            $this->offsetGet($this->getAuthIdentifierName()),
            $token
        );
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'token';
    }
}
