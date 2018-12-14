<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;

class ProductController extends Controller
{
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
        $itemObject = $productRepo->getByIdWithImage($product_id);

        if (isset($itemObject[0])) {
            $this->createCategoryBreadcrumbs($itemObject[0]->category_id);
            array_push($this->breadcrumbs, ['name' => strlen($itemObject[0]->title) > 50 ? substr($itemObject[0]->title, 0, 50).'...' : $itemObject[0]->title, 'link' => '']);

            return view('product.specific', [
                'product' => $itemObject[0],
                'breadcrumbs' => $this->breadcrumbs,
                'bids' => [ //test boden
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '120.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '100.000'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '80.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '60.000'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '40.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '20.000'
                    ]
                ]
            ]);
        }

        if (intval($product_id) != 0) {
            return view('product.specific', [
                // test recources
                'breadcrumbs' => [
                    [
                        'name' => 'EenmaalAndermaal',
                        'link' => 'home'
                    ],
                    [
                        'name' => 'product',
                        'link' => 'product'
                    ],
                    [
                        'name' => 'Alfa Romeo 1900C SUPER 1956',
                        'link' => ''
                    ]
                ],
                'product' => [
                    'title' => 'Alfa Romeo 1900C SUPER 1956',
                    'description' => 'De Alfa Romeo 1900 is een wagen van de Italiaanse autobouwer Alfa Romeo en werd geproduceerd tussen 1950 en 1958. Aan het eind van de Tweede Wereldoorlog ontwikkelden de Alfa Romeo ingenieurs de Alfa Romeo Gazella. De auto was kleiner en lichter dan de vooroorlogse Alfa\'s. De Gazella was voorzien van een zelfdragende carrosserie en was uitgerust met een tweeliter motor. Omdat de omstandigheden de productie van deze wagen niet toelieten werd slechts één prototype gebouwd. In 1950 begon het er allemaal beter uit te zien en werd het tijd om de 6C 2500 van een opvolger te voorzien. Op basis van de Gazella verschenen in 1950 de eerste Alfa 1900\'s. De fabriek werd ondertussen opnieuw opgebouwd en de 1900 werd de eerste Alfa Romeo die volledig gebouwd werd op de lopende band. Onafhankelijke carrosseriebouwers zoals Ghia en Touring leverden diverse varianten van de 1900.',
                    'start_bid' => '15.000', //startbod in euro's
                    'start_date' => '2018-11-28',
                    'auction_length' => 7, //Lengte van de veiling.
                    'payment_type' => 'Bank/Giro',
                    'payment_time' => 'Binnen 10 dagen', //Betaling binnen hoeveel dagen?
                    'image' => [
                        [
                            'link' => 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Alfa_Romeo_1900C_SUPER_1956.jpg',
                            'alt' => 'Alfa_Romeo_1900C_SUPER_1956'
                        ],
                        [
                            'link' => 'https://s1.cdn.autoevolution.com/images/gallery/ALFA-ROMEO-1900-Super-Sprint-1720_22.jpg',
                            'alt' => 'Alfa_Romeo_1900C_SUPER_1956'
                        ]
                    ]
                ],
                'seller' => [
                    'username' => 'joostLawerman',
                    'location' => 'Arnhem, Nederland',
                    'delivery_method' => 'Verzending via post',
                    'delivery_cost' => '€5,50 pakketpost binnen Nederland'
                ],
                'bids' => [ //test boden
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '120.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '100.000'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '80.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '60.000'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '40.000'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '20.000'
                    ]
                ]
            ]);
        }
        abort(404, 'Dit product is bij ons niet bekend.');
    }
}
