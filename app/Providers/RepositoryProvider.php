<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseUserRepository;
use App\Repositories\Contracts\BidsRepository;
use App\Repositories\Contracts\ItemRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\DatabaseSellerRepository;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Fakes\DatabaseItemRepository;
use App\Repositories\DatabasePasswordResetRepository;
use App\Repositories\DatabaseSecretQuestionRepository;
use App\Repositories\Contracts\PasswordResetRepository;
use App\Repositories\Contracts\SecretQuestionRepository;
use App\Repositories\DatabasePostalValidationsRepository;
use App\Repositories\Contracts\PostalValidationsRepository;
use App\Repositories\DatabaseSellerVerificationMethodRepository;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class RepositoryProvider extends ServiceProvider
{
    public $bindings = [
        CategoryRepository::class => DatabaseCategoryRepository::class,
        UserRepository::class => DatabaseUserRepository::class,
        UserProvider::class => DatabaseUserRepository::class,
        SecretQuestionRepository::class => DatabaseSecretQuestionRepository::class,
        PasswordResetRepository::class => DatabasePasswordResetRepository::class,
        ItemRepository::class => DatabaseItemRepository::class,
        BidsRepository::class => DatabaseBidsRepository::class,
        SellerRepository::class => DatabaseSellerRepository::class,
        SellerVerificationMethodRepository::class => DatabaseSellerVerificationMethodRepository::class,
        PostalValidationsRepository::class => DatabasePostalValidationsRepository::class
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
