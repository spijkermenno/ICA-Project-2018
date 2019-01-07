<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseCategoryRepository;

class MyBidsController extends Controller
{
    /**
    * @var DatabaseBidsRepository
    */
    private $bidsRepository;

    /**
     * MyBidsController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseBidsRepository $bidsRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseBidsRepository $bidsRepository)
    {
        parent::__construct($categoryRepository);

        $this->bidsRepository = $bidsRepository;
    }

    /**
     * Invoke boi
     * @param string $user
     */
    public function __invoke(string $user)
    {
        /*@TODO NAME IS SUBJECT TO CHANGE*/
        return view('my_bids_view', ['bids' => $this->bidsRepository->getAllByUser($user)]);
    }
}