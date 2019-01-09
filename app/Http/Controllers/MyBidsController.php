<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseCategoryRepository;

class MyBidsController extends Controller
{
    private $user;
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
        $this->middleware('auth');

        $this->user = auth()->user();
        $this->itemRepository = $itemRepository;
        $this->bidsRepository = $bidsRepository;
    }

    /**
     * Invoke boi
     */
    public function __invoke()
    {
        array_push($this->breadcrumbs, ['name' => 'Mijn biedingen', 'link' => '']);
        $bids = $this->bidsRepository->getAllByUser(auth()->user()->getAuthIdentifier());
        
        return view('my_bids_view', ['bids' => $this->bidsRepository->getAllByUser(auth()->user()->getAuthIdentifier())]);
    }
}
