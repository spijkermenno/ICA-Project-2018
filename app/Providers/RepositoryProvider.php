<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;
use App\Repositories\DatabaseUserRepository;
use App\Repositories\Contracts\ItemRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Fakes\DatabaseItemRepository;
use App\Repositories\DatabasePasswordResetRepository;
use App\Repositories\Contracts\PasswordResetRepository;

class RepositoryProvider extends ServiceProvider
{
    public $bindings = [
        CategoryRepository::class => DatabaseCategoryRepository::class,
        UserRepository::class => DatabaseUserRepository::class,
        UserProvider::class => DatabaseUserRepository::class,
        PasswordResetRepository::class => DatabasePasswordResetRepository::class,
        ItemRepository::class => DatabaseItemRepository::class
    ];

    public function register()
    {
        collect($this->bindings)->map(function ($to, $from) {
            $this->app->bind(
                $from,
                $to
            );
        });
    }
}
