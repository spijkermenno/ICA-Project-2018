<?php

namespace App\Http\Controllers;

use App\Repositories\DatabasePaymentMethodRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Repositories\DatabaseCategoryRepository;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var DatabaseCategoryRepository
     */
    public $categoryRepository;
    public $breadcrumbs = [
        [
            'name' => 'EenmaalAndermaal',
            'link' => '/'
        ]
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        View::share('rubrieken', $this->categoryRepository->getAllByParentIdOrdered(-1));
        View::share('viewName', Route::getFacadeRoot()->current()->uri());
    }
}
