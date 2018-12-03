<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepository extends UserProvider
{
    public function create(array $date): Authenticatable;
}
