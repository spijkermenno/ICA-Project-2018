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
    private $itemRepository;

    /**
     * MyBidsController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseBidsRepository $bidsRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseBidsRepository $bidsRepository, \App\Repositories\DatabaseItemRepository $itemRepository)
    {
        parent::__construct($categoryRepository);
        $this->itemRepository = $itemRepository;
        $this->bidsRepository = $bidsRepository;
    }

    /**
     * Invoke boi
     * @param string $user
     */
    public function __invoke(string $user)
    {
        return view('my_bids_view', ['bids' => $this->bidsRepository->getAllByUser($user)]);
    }
}
