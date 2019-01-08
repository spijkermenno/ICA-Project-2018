<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class SearchController extends Controller
{
    /**
     * @var DatabaseItemRepository
     */
    private $itemRepository;

    /**
     * SearchController constructor.
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseItemRepository $itemRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseItemRepository $itemRepository)
    {
        parent::__construct($categoryRepository);

        $this->itemRepository = $itemRepository;

        array_push($this->breadcrumbs, ['name' => 'Zoeken', 'link' => '']);
    }

    public function __invoke(Request $request)
    {
        $buttons = 2;
        $searchQuery = trim($request->get('query'));
        array_push($this->breadcrumbs, [
            'name' => $searchQuery,
            'link' => route('search', ['query' => $searchQuery])
        ]);

        if ($searchQuery == null) {
            return view('search.result_page', [
                'breadcrumbs' => $this->breadcrumbs,
                'searchQuery' => '',
                'products' => []
            ]);
        }

        $searchQueries = explode(' ', $searchQuery);

        $products = $this->itemRepository->getItemsBySearch($searchQueries, 'title', [
            'title',
            'selling_price',
            '[end]',
            'start',
            'id'
        ], 24);

        $images = [];
        if (count($products) > 0) {
            $images = $this->itemRepository->getMultipleImages(array_pluck($products, 'id'));
        }

        $images = collect($images)->keyBy('item_id');
        $products->setCollection($products->getCollection()->map(function ($item) use ($images) {
            $item->filename = optional($images->get($item->id))->filename;
            return $item;
        }));

        $products->appends([
            'query' => $searchQuery
        ]);

        return view(
            'search.result_page',
            [
                'breadcrumbs' => $this->breadcrumbs,
                'products' => $products,
                'buttons' => $buttons,
                'searchQuery' => $searchQuery
            ]
        );
    }
}
