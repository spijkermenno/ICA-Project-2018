<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        View::share('rubrieken', $this->categoryRepository->getAllParents());
    }
}
