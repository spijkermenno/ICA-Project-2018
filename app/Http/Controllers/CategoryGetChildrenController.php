<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;

class CategoryGetChildrenController extends Controller
{
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
    }

    public function __invoke($id)
    {
        $children = $this->categoryRepository->getAllByParentId($id);
        $parentName = $this->categoryRepository->getById($id)[0]->name;

        if (count($children)) {
            $result = '<div class="form-group mt-2" id="' . $id . '">
                <label for="categories">Kies een subrubriek voor ' . $parentName . '</label>
               <select class="form-control" onchange="retrieveNewSubrubriek(this.options[this.selectedIndex].value); this.disabled = true;" id="categories">
                                   <option selected disabled>Rubriek</option>
';

            foreach ($children as $item) {
                $result .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
            $result .= '</select></div>';
            return $result;
        }
        return '<input type="hidden" name="category_id" value="' . $id . '"/>';
    }
}
