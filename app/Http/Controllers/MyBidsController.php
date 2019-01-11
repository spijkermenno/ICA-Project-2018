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
        // dd($bids);
        $losingBids = [];
        $winningBids = [];
        $lostBids = [];
        $wonBids = [];

        foreach($bids as $bid){
            $bid->image = $this->itemRepository->getAllImages($bid->id)[0]->filename;
            if($bid->auction_closed == 1){
                if($bid->user_bid == $bid->highest_bid){
                    array_push($wonBids,$bid);
                }
                else{
                    array_push($lostBids, $bid);
                }
            } else{
                if($bid->user_bid == $bid->highest_bid){
                    array_push($winningBids,$bid);
                }
                else{
                    array_push($losingBids, $bid);
                }
            }

        }
        
        return view('account.bids', 
            compact('losingBids', 'winningBids', 'wonBids', 'lostBids')
        );
    }
}
