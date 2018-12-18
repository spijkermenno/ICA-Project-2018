<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class SearchController extends Controller
{
    private $itemRepository;

    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseItemRepository $databaseItemRepository)
    {
        parent::__construct($categoryRepository);

        $crumb = ['name' => 'Zoeken', 'link' => ''];
        array_push($this->breadcrumbs, $crumb);
        $this->itemRepository = $databaseItemRepository;
    }

    public function simplify()
    {
        if (isset($_GET['query'])) {
            return redirect('/zoek/' . $_GET['query']);
        } else {
            abort(404);
        }
    }

    public function search($query)
    {
        $crumb = ['name' => $query, 'link' => ''];
        array_push($this->breadcrumbs, $crumb);

        $items = null;
        if (is_array($query)) {
            $items = [];
            foreach ($query as $item) {
                array_push($items, $this->itemRepository->getItemsBySearch($item, 'title', 24));
            }
        } else {
            $items = $this->itemRepository->getItemsBySearch($query, 'title', 24);
        }
        if (count($items)) {
            return view('search.resultPage', ['breadcrumbs' => $this->breadcrumbs, 'products' => $items, 'buttons' => 2, 'searchQuery' => $query]);
        }

        return view('search.noResultPage', ['breadcrumbs' => $this->breadcrumbs, 'searchQuery' => $query]);
    }
}
