<?php

namespace App\Http\Controllers;

use phpDocumentor\Reflection\Types\Object_;
use App\Repositories\DatabaseBidsRepository;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class ProductController extends Controller
{
    /**
     * @var DatabaseBidsRepository
     */
    private $bidsRepository;

    /**
     * ProductController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseBidsRepository $bidsRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseBidsRepository $bidsRepository)
    {
        parent::__construct($categoryRepository);

        $this->bidsRepository = $bidsRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.product', [
            'breadcrumbs' => [
                [
                    'name' => 'EenmaalAndermaal',
                    'link' => 'home'
                ],
                [
                    'name' => 'product',
                    'link' => ''
                ]
            ],
        ]);
    }

    public function product_no_name($product)
    {
        $productRepo = app()->make(DatabaseItemRepository::class);
        $itemObjects = $productRepo->getById($product);
        if (isset($itemObjects[0])) {
            return redirect()->route('product_specific', ['product' => $product, 'name' => str_slug($itemObjects[0]->title)]);
        }
        abort(404);
    }

    public function createCategoryBreadcrumbs($categoryID)
    {
        $parent = $this->categoryRepository->getById($categoryID)[0];
        if ($parent->parent != '-1') {
            $this->createCategoryBreadcrumbs($parent->parent);
        }
        array_push($this->breadcrumbs, ['name' => $parent->name, 'link' => '/rubriek/'.$parent->id . '/']);
    }

    public function product_specific($product_id)
    {
        $productRepo = app()->make(DatabaseItemRepository::class);
        $itemObject = $productRepo->getById($product_id);

        if (isset($itemObject[0])) {
            $itemPictures = $productRepo->getAllImages($product_id);
            $this->createCategoryBreadcrumbs($itemObject[0]->category_id);
            array_push($this->breadcrumbs, ['name' => strlen($itemObject[0]->title) > 50 ? substr($itemObject[0]->title, 0, 50).'...' : $itemObject[0]->title, 'link' => '']);

            $bids = $this->bidsRepository->get_top_bids(6, $product_id);

            if (count($bids) == 0) {
                $bids[0] = new Object_();
                $bids[0]->highest_bid = ($itemObject[0]->selling_price);
                $bids[0]->user_name = '';
                $bids[0]->date = '';
            }

            return view('product.specific', [
                'product' => $itemObject[0],
                'images' => $itemPictures,
                'breadcrumbs' => $this->breadcrumbs,
                'bids' => $bids
            ]);
        }

        abort(404, 'Dit product is bij ons niet bekend.');
    }
}
