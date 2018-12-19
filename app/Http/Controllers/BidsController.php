<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class BidsController extends Controller
{
    /**
     * @var DatabaseBidsRepository
     */
    private $bidsRepository;
    /**
     * @var DatabaseItemRepository
     */
    private $itemRepository;

    /**
     * BidsController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseBidsRepository $bidsRepository
     * @param DatabaseItemRepository $itemRepository
     */
    public function __construct(
        DatabaseCategoryRepository $categoryRepository,
        DatabaseBidsRepository $bidsRepository,
        DatabaseItemRepository $itemRepository
    ) {
        parent::__construct($categoryRepository);

        $this->bidsRepository = $bidsRepository;
        $this->itemRepository = $itemRepository;

        $this->middleware('auth');
    }

    public function create_bid(Request $request)
    {
        $data = $request->validate([
            'price' => 'required',
            'product' => 'required:exists:items,id:integer'
        ]);
        $bid = [
            'item_id' => $data['product'],
            'price' => $data['price'],
            'user_name' => auth()->user()->name
        ];

        $this->bidsRepository->createBid($bid);
        $this->itemRepository->update_selling_price($data['product'], $data['price']);

        $product = $this->itemRepository->getById($data['product'])[0];

        return redirect()->route('product_specific', [
            $data['product'],
            seo_url($product->title)
        ])->with('successful_bid', [
            'price' => number_format($bid['price'], 2, ',', '.')
        ]);
    }
}
