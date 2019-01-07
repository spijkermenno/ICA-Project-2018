<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\DatabasePaymentMethodRepository;

class AuctionController extends Controller
{
    private $user;
    private $paymentMethodRepository;
    private $databaseItemRepository;

    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabasePaymentMethodRepository $databasePaymentMethodRepository, DatabaseItemRepository $databaseItemRepository)
    {
        parent::__construct($categoryRepository);
        $this->middleware('auth');

        $this->user = auth()->user();
        $this->paymentMethodRepository = $databasePaymentMethodRepository;
        $this->databaseItemRepository = $databaseItemRepository;
        array_push($this->breadcrumbs, ['name' => 'veiling toevoegen', 'link' => '']);
    }

    public function newProduct(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|string|min:4|max:255',
            'category_id'   => 'required|int',
            'description'   => 'required|string|min:4',
            'start_price'   => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'payment_method'=> 'required|string',
            'duration'      => 'required|int',
        ]);

        if($this->databaseItemRepository->create($request) == true){
            $id = $this->databaseItemRepository->getLastId();
            $errors = $this->databaseItemRepository->saveImages($id->id);
            if (count($errors) > 0) {
                dump($errors);
                exit;
            }
            return redirect()->route('home');
        }
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
