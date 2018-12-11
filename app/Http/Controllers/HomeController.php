<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;
use Carbon\Carbon;

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

        $popular_products = [];
        $fast_ending_products = [];

        $testProduct = [
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
            'buttons' => 3,
            'end' => '2018-12-11 15:39:3.703'
        ];



        for ($i = 0; $i < 3; $i++) {
            $date = Carbon::now();
            $date->addDays(rand(0, 6));
            $date->addHours(rand(0, 23));
            $date->addMinutes(rand(0, 59));

            $date->addHour();

            $popular_products[] = array_merge($testProduct, ['end' => $date]);
        }

        for ($i = 0; $i < 12; $i++) {
            $fast_ending_products[] = array_merge($testProduct, ['end' => $date]);
        }

        return view('home', [
            'popular_products' => $popular_products,
            'fast_ending_products' => $fast_ending_products
        ]);
    }
}
