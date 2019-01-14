<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;

class CategoryController extends Controller
{
    private $itemRepository;

    /**
     * Show the application dashboard.
     *
     * @param DatabaseCategoryRepository $categoryRepository
     * @param DatabaseItemRepository $databaseItemRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository, DatabaseItemRepository $databaseItemRepository)
    {
        parent::__construct($categoryRepository);
        $crumb = ['name' => 'Rubrieken', 'link' => route('rubrieken')];
        array_push($this->breadcrumbs, $crumb);
        $this->itemRepository = $databaseItemRepository;
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

    public function getBreadcrumbs($product_id, $is_admin = false)
    {
        $parents = $this->categoryRepository->getAllParentsById($product_id);
        $crumb = [];
        if ($is_admin) {
            foreach ($parents as $parent) {
                array_push($this->breadcrumbs, ['name' => $parent->name, 'link' => route('view_rubriek', ['id' => $parent->id])]);
            }
        } else {
            foreach ($parents as $parent) {
                array_push($this->breadcrumbs, ['name' => $parent->name, 'link' => route('rubriek_without_name', ['category_id' => $parent->id])]);
            }
        }

        $self = $this->categoryRepository->getById($product_id)[0];
        array_push($this->breadcrumbs, ['name' => $self->name, 'link' => '']);
    }

    public function getItemsOfParent($product_id)
    {
        $temp_items = [];
        $parents_array = [];

        $subrubrieken = $this->categoryRepository->getChildrenFor([$product_id]);

        foreach ($subrubrieken as $subrubriek) {
            array_push($parents_array, $subrubriek->id);
        }

        $sub = $this->categoryRepository->getChildrenFor($parents_array);

        foreach ($sub as $item) {
            $temp = $this->categoryRepository->getChildrenFor([$item->id]);
            if (count($temp) == 0) {
                array_push($temp_items, $this->itemRepository->getbyCategoryIdWithImage($item->id));
            } else {
                $this->getItemsOfParent($item->id);
            }
        }
        return $temp_items;
    }

    public function rubriek($product_id)
    {
        $images = [];

        $ids = array_pluck($this->categoryRepository->getAllChildrenForParent($product_id), 'id');
        $paginated = $this->itemRepository->getMultipleByCategoryIds($ids, [
            'title',
            'selling_price',
            '[end]',
            'start',
            'id'
        ]);

        $this->getBreadcrumbs($product_id);

        return view('rubrieken.rubriek_deep', [
            'products' => $paginated,
            'sidebar' => [
                'parents' => $this->categoryRepository->getAllParentsById($product_id),
                'current' => $this->categoryRepository->getById($product_id),
                'children' => $this->categoryRepository->getAllByParentIdOrdered($product_id)
            ],
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function rubriek_all_children($product_id)
    {
        $this->getBreadcrumbs($product_id);

        return view('rubrieken.rubriek', [
            'popular_products' => [],
            'fast_ending_products' => [],
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

    public function view_rubriek($id)
    {
        if ($id == -1) {
            return redirect()->route('rubrieken');
        }

        $self = $this->categoryRepository->getById($id);

        if (count($self) < 1) {
            abort(404);
        }

        $this->getBreadcrumbs($id, true);

        return view('rubrieken.rubrieken', [
            'self' => $self,
            'alphabet' => $this->getAlphabet($id),
            'parents' => $this->categoryRepository->getLevelWithChildren($id),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function new_rubriek($parent_id)
    {
        $parent = $this->categoryRepository->getById($parent_id);

        if (empty($parent)) {
            return redirect()->route('rubrieken')->with('error', 'Deze rubriek bestaat niet of kan niet aangepast worden');
        }

        $this->getBreadcrumbs($parent_id, true);

        return view('rubrieken.add_rubriek', [
            'parent_id' => $parent_id,
            'parent_name' => $parent[0]->name,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function add_rubriek($parent_id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:45|min:2'
        ]);

        $name = $request->post('name');

        $this->categoryRepository->create($name, $parent_id);

        return redirect()->route('view_rubriek', ['id' => $parent_id])->with('success', 'Rubriek succesvol toegevoegd');
    }

    public function edit_rubriek($id)
    {
        $rubriek = $this->categoryRepository->getById($id);

        if (empty($rubriek) || $id == -1) {
            return redirect()->route('rubrieken')->with('error', 'Deze rubriek bestaat niet of kan niet aangepast worden');
        }

        $this->getBreadcrumbs($id, true);

        return view('rubrieken.edit_rubriek', [
            'id' => $id,
            'name' => $rubriek[0]->name,
            'order_number' => $rubriek[0]->order_number,
            'parent' => $rubriek[0]->parent,
            'inactive' => $rubriek[0]->inactive,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function update_rubriek($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:45|min:2',
            'order_number' => 'required|integer|max:2147483647|min:1'
        ]);

        $name = $request->post('name');
        $order_number = $request->post('order_number');

        $rubriek = $this->categoryRepository->getById($id);

        if ($name != $rubriek[0]->name) {
            $this->categoryRepository->updateName($id, $name);
        }

        if ($order_number != $rubriek[0]->order_number) {
//            $this->categoryRepository->updateOrderNumber($id, $rubriek[0]->order_number, $order_number);
            $this->categoryRepository->changeOrderNumber($id, $order_number);
        }

        if ($name != $rubriek[0]->name && $order_number != $rubriek[0]->order_number) {
            $message = 'Naam en volgnummer zijn succesvol geüpdatet';
        } elseif ($name != $rubriek[0]->name) {
            $message = 'Naam is succesvol geüpdatet';
        } elseif ($order_number != $rubriek[0]->order_number) {
            $message = 'Volgnummer is succesvol geüpdatet';
        } else {
            $message = 'Er zijn geen wijzigingen aangebracht';
        }

        return redirect()->route('view_rubriek', ['id' => $id])->with('success', $message);
    }

    public function show_disable_rubriek($id)
    {
        $self = $this->categoryRepository->getById($id);

        if (empty($self) || $id == -1) {
            return redirect()->route('rubrieken')->with('error', 'Deze rubriek bestaat niet of kan niet aangepast worden');
        }

        $this->getBreadcrumbs($id, true);

        return view('rubrieken.disable_rubriek', [
            'id' => $id,
            'name' => $self[0]->name,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function disable_rubriek($id)
    {
        $self = $this->categoryRepository->getById($id);

        $this->categoryRepository->disable($id);

        return redirect()->route('view_rubriek', ['id' => $self[0]->parent])->with('success', 'Rubriek en subrubrieken succesvol uitgefaseerd');
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
