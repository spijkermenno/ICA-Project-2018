<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\DatabasePaymentMethodRepository;

class AuctionController extends Controller
{
    private $user;
    private $paymentMethodRepository;
    private $databaseItemRepository;
    private $databaseBidsRepository;

    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseBidsRepository $databaseBidsRepository, DatabasePaymentMethodRepository $databasePaymentMethodRepository, DatabaseItemRepository $databaseItemRepository)
    {
        parent::__construct($categoryRepository);
        $this->middleware('auth');

        $this->user = auth()->user();
        $this->paymentMethodRepository = $databasePaymentMethodRepository;
        $this->databaseItemRepository = $databaseItemRepository;
        $this->databaseBidsRepository = $databaseBidsRepository;
    }

    public function newProduct(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:4|max:255',
            'category_id' => 'required|int',
            'description' => 'required|string|min:4',
            'country' => 'required',
            'city' => 'required|string|min:4',
            'start_price' => 'required|numeric|min:1',
            'shipping_cost' => 'required|numeric',
            'payment_method' => 'required|string',
            'duration' => 'required|int',
        ]);

        if ($this->databaseItemRepository->create($request) == true) {
            $id = $this->databaseItemRepository->getLastId();
            $errors = $this->databaseItemRepository->saveImages($id->id);
            if (count($errors) > 0) {
                return redirect()->route('auction.add', ['error' => $errors]);
            }
            return redirect()->route('product_no_name', ['product' => $id->id]);
        }
    }

    public function index()
    {
        $auction_rubrieken = $this->categoryRepository->getAllByParentId(-1);
        $payment_methods = $this->paymentMethodRepository->getAll();
        array_push($this->breadcrumbs, ['name' => 'veiling toevoegen', 'link' => '']);
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
        } else {
            $error = '';
        }

        return view('product.new_item', [
            'breadcrumbs' => $this->breadcrumbs,
            'auction_rubrieken' => $auction_rubrieken,
            'payment_methods' => $payment_methods,
            'error' => $error,
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

    public function myAuctions()
    {
        array_push($this->breadcrumbs, ['name' => 'Mijn veilingen', 'link' => '']);

        $openAuctions = $this->databaseItemRepository->getBySellerName(auth()->user()->getAuthIdentifier(), 0, 3);
        $closedAuctions = $this->databaseItemRepository->getBySellerName(auth()->user()->getAuthIdentifier(), 1, 3);

        foreach ($openAuctions as $openAuction) {
            $temp = $this->databaseBidsRepository->getTopBids(1, $openAuction->id);
            if (count($temp) > 0) {
                $openAuction->highestBid = $temp[0];
            } else {
                $openAuction->highestBid = null;
            }

            $temp2 = $this->databaseItemRepository->getAllImages($openAuction->id);
            if (count($temp2) > 0) {
                $openAuction->image = $temp2[0]->filename;
            }
        }

        foreach ($closedAuctions as $closedAuction) {
            $temp = $this->databaseBidsRepository->getTopBids(1, $closedAuction->id);
            if (count($temp) > 0) {
                $closedAuction->highestBid = $temp[0];
            } else {
                $closedAuction->highestBid = null;
            }

            $temp2 = $this->databaseItemRepository->getAllImages($closedAuction->id);
            if (count($temp2) > 0 && isset($temp2[0]->filename)) {
                $closedAuction->image = $temp2[0]->filename;
            } else {
                $closedAuction->image = '';
            }
        }

        return view('account.veilingen', [
            'breadcrumbs' => $this->breadcrumbs,
            'openVeilingen' => $openAuctions,
            'geslotenVeilingen' => $closedAuctions
        ]);
    }
}
