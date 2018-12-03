<?php

namespace App\Http\Controllers;

class RubriekenController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rubrieken.rubrieken', [
            'alphabet' => $this->getAlphabet(),
            'parents' => $this->categoryRepository->getLevelWithChildren(
                -1
            )
        ]);
    }

    public function rubriek()
    {
        return view('rubrieken.rubriek');
    }

    /**
     * Generates an array from A to Z with an active value from the category parents
     *
     * @return array
     */
    private function getAlphabet()
    {
        $alphabet = [];
        for ($i = 65; $i < 91; $i++) {
            $alphabet[] = [
                'letter' => chr($i),
                'active' => false
            ];
        }

        $parents = $this->categoryRepository->getAllParents();

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
