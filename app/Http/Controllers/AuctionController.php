<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\DatabasePaymentMethodRepository;

class AuctionController extends Controller
{
    private $user;
    private $paymentMethodRepository;

    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabasePaymentMethodRepository $databasePaymentMethodRepository)
    {
        parent::__construct($categoryRepository);
        $this->middleware('auth');

        $this->user = auth()->user();
        $this->paymentMethodRepository = $databasePaymentMethodRepository;
        array_push($this->breadcrumbs, ['name' => 'veiling toevoegen', 'link' => '']);
    }

    public function index()
    {
        $auction_rubrieken = $this->categoryRepository->getAllByParentId(-1);
        $payment_methods = $this->paymentMethodRepository->getAll();

        return view('product.new_item', [
            'breadcrumbs' => $this->breadcrumbs,
            'auction_rubrieken' => $auction_rubrieken,
            'payment_methods' => $payment_methods,
            'auctionDurations' => [
                [
                    'value' => 1,
                    'text' => '1 Dag',
                    'default' => ''
                ],
                [
                    'value' => 3,
                    'text' => '3 Dagen',
                    'default' => ''
                ],
                [
                    'value' => 5,
                    'text' => '5 Dagen',
                    'default' => ''
                ],
                [
                    'value' => 7,
                    'text' => '7 Dagen',
                    'default' => 'selected'
                ],
                [
                    'value' => 10,
                    'text' => '10 Dagen',
                    'default' => ''
                ]
            ]
        ]);
    }
}
