<?php
/**
 * Author: Ivo Breukers
 * Date: 21-Nov-18
 * Time: 14:14
 */

namespace App\Repositories;


class FakeCategoryRepository
{
    protected $model;

    public function __construct(FakeCategory $fakeCategory)
    {
        $this->model = $fakeCategory;
    }

    public function getCategoryById(int $id)
    {
        return [
            'ID' => 1,
            'Name' => 'Verzamelen',
            'Parent' => -1
        ];
    }

    public function getAllCategories()
    {
        return [
            ['ID' => 1,'Name' => 'Verzamelen','Parent' => -1],
            ['ID' => 30,'Name' => 'Overig klassiek speelgoed','Parent' => 19016],
            ['ID' =>32,'Name' =>'Poppen','Parent' =>1],
            ['ID' =>34,'Name' =>'Reclamevoorwerpen', 'Parent' =>1],
            ['ID' =>35, 'Name' =>'Overige reclamevoorwerpen', 'Parent' =>34],
            ['ID' =>38, 'Name' =>'Overige Coca-Cola', 'Parent' =>62848],
            ['ID' =>57, 'Name' =>'Film objecten', 'Parent' =>196],
            ['ID' =>63, 'Name' =>'Stripboeken', 'Parent' =>267],
            ['ID' =>64, 'Name' =>'Overige comics', 'Parent' =>900],
            ['ID' =>80, 'Name' =>'Verzamelstrips', 'Parent' =>63],
            ['ID' =>117, 'Name' =>'Overige beren en knuffels', 'Parent' =>386]
        ];
    }
}