<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;

class RubriekenController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $crumb = ['name' => 'Rubrieken', 'link' => '/rubrieken'];
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

    public function new_rubriek($parent_id)
    {
        $parent = $this->categoryRepository->getById($parent_id);

        return view('rubrieken.add_rubriek', [
            'parent_id' => $parent_id,
            'parent_name' => $parent[0]->name
        ]);
    }

    public function add_rubriek($parent_id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:2'
        ]);

        $name = $request->post('name');

        $this->categoryRepository->create($name, $parent_id);

        return redirect()->to('/rubrieken/')->with('success', 'Rubriek succesvol toegevoegd');
    }

    public function edit_rubriek($id)
    {
        $rubriek = $this->categoryRepository->getById($id);

        return view('rubrieken.edit_rubriek', [
            'id' => $id,
            'name' => $rubriek[0]->name,
            'order_number' => $rubriek[0]->order_number,
            'parent' => $rubriek[0]->parent,
            'inactive' => $rubriek[0]->inactive
        ]);
    }

    public function update_rubriek($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:2',
            'order_number' => 'required|max:11|min:1'
        ]);

        $name = $request->post('name');
        $order_number = $request->post('order_number');

        $rubriek = $this->categoryRepository->getById($id);

        if($name != $rubriek[0]->name)
        {
            $this->categoryRepository->updateName($id, $name);
        }

        if ($order_number != $rubriek[0]->order_number)
        {
            $this->categoryRepository->updateOrderNumber($id, $rubriek[0]->order_number, $order_number);
        }

        if($name != $rubriek[0]->name && $order_number != $rubriek[0]->order_number)
        {
            $message = 'Naam en volgnummer zijn succesvol geüpdatet';
        } else if($name != $rubriek[0]->name)
        {
            $message = 'Naam is succesvol geüpdatet';
        } else if($order_number != $rubriek[0]->order_number)
        {
            $message = 'Volgnummer is succesvol geüpdatet';
        } else
        {
            $message = 'Er zijn geen wijzigingen aangebracht';
        }

        return redirect()->to('/rubrieken/')->with('success', $message);
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
