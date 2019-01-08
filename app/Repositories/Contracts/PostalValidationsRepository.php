<?php

namespace App\Repositories\Contracts;

use App\User;

interface PostalValidationsRepository
{
    public function getByUser(User $user);
}
