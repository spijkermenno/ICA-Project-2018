<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;
use Illuminate\Support\Carbon;

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

        $current_bid = number_format($bid['price'], 2, ',', '.');
        $minimal_to_up = getMinimalTopUp($bid['price']);

        print_r($data['price'] . ' - ' . $minimal_to_up . ' - ' . ($data['price'] + $minimal_to_up) . ' - ' . $product->selling_price);
        exit;

        $response = redirect()->route('product_specific', [
            $data['product'],
            seo_url($product->title)
        ]);

        if($current_date > $start_date && $current_date < $end_date)
        {
            if(($data['price'] + $minimal_to_up) > $product->selling_price)
            {
                $this->bidsRepository->createBid($bid);
                $this->itemRepository->update_selling_price($data['product'], $data['price']);

                return $response->with('successful_bid', [
                    'price' => $current_bid
                ]);
            }

            return $response->with('error_bid', [
                'message' => 'Uw bod van €' . $current_bid . ' is te laag om het huidige bod van €' . number_format($product->selling_price, 2, ',', '.') . ' te overbieden'
            ]);
        }

        return $response->with('error_bid', [
            'message' => 'Het is niet toegestaan op dit product te bieden'
        ]);
    }
}
