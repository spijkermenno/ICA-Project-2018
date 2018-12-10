<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;

class RubriekenController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $crumb = ['name' => 'rubrieken', 'link' => '/rubrieken'];
        array_push($this->breadcrumbs, $crumb);
    }

    public function index()
    {
        $this->breadcrumbs[1]['link'] = '';
        return view('rubrieken.rubrieken', [
            'alphabet' => $this->getAlphabet(),
            'parents' => $this->categoryRepository->getLevelWithChildren(-1),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function getBreadcrumbs($product_id)
    {
        $parents = $this->categoryRepository->getAllParentsById($product_id);
        $crumb = [];
        foreach ($parents as $parent) {
            array_push($this->breadcrumbs, ['name' => $parent->name, 'link' => '/rubriek/'.$parent->id]);
        }

        $self = $this->categoryRepository->getById($product_id)[0];

        array_push($this->breadcrumbs, ['name' => $self->name, 'link' => '']);
    }

    public function rubriek($product_id, $product_name)
    {
        $this->getBreadcrumbs($product_id);

        return view('rubrieken.rubriek', [
            'sidebar' => [
                'parents' => $this->categoryRepository->getAllParentsById($product_id),
                'current' => $this->categoryRepository->getById($product_id),
                'children' => $this->categoryRepository->getAllByParentIdOrdered($product_id)
            ],
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function rubriek_no_name($id)
    {
        $rubriekRepo = app()->make(CategoryRepository::class);
        $rubriekObjects = $rubriekRepo->getById($id);
        if (isset($rubriekObjects[0])) {
            return redirect()->route('rubriek_with_name', ['product' => $id, 'product_name' => str_slug($rubriekObjects[0]->name)]);
        }
        return redirect()->route('rubrieken');
    }

    /**
     * Generates an array from A to Z with an active value from the category parents
     *
     * @param int $parent_id
     * @return array
     */
    private function getAlphabet($parent_id = -1)
    {
        $alphabet = [];
        for ($i = 65; $i < 91; $i++) {
            $alphabet[] = [
                'letter' => chr($i),
                'active' => false
            ];
        }

        $parents = $this->categoryRepository->getAllByParentId($parent_id);

        foreach ($alphabet as $key => $item) {
            foreach ($parents as $parent) {
                if ($item['letter'] == $parent->name[0] && $item['active'] == false) {
                    $alphabet[$key]['active'] = true;
                }
            }
        }

        return $alphabet;
    }
}
