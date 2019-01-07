<?php

namespace App\Http\Controllers;

use phpDocumentor\Reflection\Types\Object_;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class MyBidsController extends Controller
{
     /**
     * @var DatabaseBidsRepository
     */
    private $bidsRepository;

    /**
     * ProductController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseBidsRepository $bidsRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseBidsRepository $bidsRepository)
    {
        parent::__construct($categoryRepository);

        $this->bidsRepository = $bidsRepository;
    }

    public function getAllByUser(string $user){

    }
}