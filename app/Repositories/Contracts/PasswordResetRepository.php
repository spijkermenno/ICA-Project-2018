<?php

namespace App\Repositories\Contracts;

interface PasswordResetRepository
{
    public function updateTokenByUserIdentifier($identifier, $token): bool;
}
