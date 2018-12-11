<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class HomeController extends Controller
{
    /**
     * @var DatabaseItemRepository
     */
    private $itemRepository;

    /**
     * Create a new controller instance.
     *
     * @param DatabaseItemRepository $itemRepository
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseItemRepository $itemRepository, DatabaseCategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->itemRepository = $itemRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('home', [
//            'popular_products' => $this->itemRepository->getMostPopularItems(3),
//            'fast_ending_products' => $this->itemRepository->getSoonEndingItems(9)
//        ]);

        return view('home', [
            'popular_products' => [
                [
                    'title' => 'popular',
                    'description' => 'foobar',
                    'start_price' => 1.00,
                    'selling_price' => 2.00,
                    'payment_instruction' => 'barfoo',
                    'shipping_cost' => 5.95,
                    'seller' => 'JoostAntiek',
                    'buyer' => 'MennoAntiek',
                    'duration' => 7,
                    'minimale_verhoging' => getMinimalTopUp(2),
                    'time_left' => '10:13:42',
                    'buttons' => 3
                ]
            ],
            'fast_ending_products' => [
                [
                    'title' => 'default',
                    'description' => 'foobar',
                    'start_price' => 1.00,
                    'selling_price' => 500.00,
                    'payment_instruction' => 'barfoo',
                    'shipping_cost' => 5.95,
                    'seller' => 'JoostAntiek',
                    'buyer' => 'MennoAntiek',
                    'duration' => 7,
                    'minimale_verhoging' => getMinimalTopUp(500),
                    'time_left' => '00:00:12',
                    'buttons' => 2
                ]
            ]
        ]);
    }
}
