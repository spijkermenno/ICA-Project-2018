<?php

namespace App\Repositories\Contracts;

interface PasswordResetRepository
{
    public function getByUserEmail($email);
}
