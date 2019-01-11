<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $product = $this->itemRepository->getById($data['product'])[0];
        $current_date = Carbon::now();
        $start_date = Carbon::parse($product->start);
        $end_date = Carbon::parse($product->end);
        $minimal_to_up = getMinimalTopUp($bid['price']);
        $current_bid = priceFormat($bid['price']);
        $response = redirect()->route('product_specific', [
            $data['product'],
            seo_url($product->title)
        ]);

        if ($current_date > $start_date && $current_date < $end_date && $bid['user_name'] != $product->seller) {
            if (($data['price'] - $minimal_to_up) >= $product->selling_price) {
                $this->bidsRepository->createBid($bid);
                $this->itemRepository->updateSellingPrice($data['product'], $data['price']);

                return $response->with('successful_bid', [
                    'price' => $current_bid
                ]);
            }

            return $response->with('error_bid', [
                'message' => 'Uw bod van €' . $current_bid . ' is te laag om de huidige prijs van €' . priceFormat($product->selling_price) . ' te overbieden, uw bod moet minimaal €' . priceFormat(($product->selling_price + $minimal_to_up)) . ' zijn'
            ]);
        }

        return $response->with('error_bid', [
            'message' => 'Het is niet toegestaan op dit product te bieden'
        ]);
    }
}
