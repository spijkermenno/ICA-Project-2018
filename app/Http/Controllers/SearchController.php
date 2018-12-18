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
        $searchQuery = trim($request->get('query'));

        if ($searchQuery == null) {
            return view('search.noResultPage', ['breadcrumbs' => $this->breadcrumbs, 'searchQuery' => '']);
        }

        array_push($this->breadcrumbs, ['name' => $searchQuery, 'link' => '']);

        $breadCrumbs = $this->breadcrumbs;
        $products = $this->itemRepository->getItemsBySearch($searchQuery, 'title', [
            'title',
            'selling_price',
            '[end]',
            'id'
        ], 24);
        $buttons = 2;

        $products->appends([
            'query' => $request->get('query')
        ]);

        return view(
            'search.resultPage',
            compact(
                'breadCrumbs',
                'products',
                'buttons',
                'searchQuery'
            )
        );
    }
}
