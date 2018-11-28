<?php

namespace App\Http\Controllers;

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

    public function product_specific($product_id)
    {
        if (intval($product_id) != 0) {
            return view('product.product_specific', [
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
                        'name' => 'Antieke Microfoon',
                        'link' => ''
                    ]
                ],
                'product' => [
                    'title' => 'Antieke Microfoon',
                    'description' => 'Schilderijen kunnen uiteraard kunst zijn (als zij artistieke waarde hebben) en ook antiek (als zij aan het ouderdomscriterium voldoen). De veelgehoorde uitdrukking "kunst en antiek" suggereert dan ook ten onrechte dat het hier om twee categorieën zou gaan die elkaar uitsluiten. De waarde van een antiek schilderij is, los gezien van de artistieke waarde, afhankelijk van onder meer de staat waarin het verkeert, het onderwerp (hier zijn modetrends herkenbaar) en de toepasselijkheid (vaak is een schilderij dat een bepaalde lokaliteit weergeeft, in de regio zelf meer gewild dan elders). Ook gravures, meestal etsen, worden veel door antiquairs verhandeld. Dit betreft algemeen plaatwerk, stadsgezichten, kaarten en kopieën van schilderijen. Sommige etsen zijn na het drukken met de hand ingekleurd. Omdat etsen reproduceerbaar zijn en dus minder zeldzaam dan schilderijen, zijn ze over het algemeen veel goedkoper. Oude boeken en atlassen bevatten eveneens vaak gravures, die soms los verhandeld worden.',
                    'start_bid' => '1,00',
                    'image' => [
                        [
                            'link' => 'http://www.transparentpng.com/download/antique/antique-telephone-photo-png-0.png',
                            'alt' => 'Antieke telefoon'
                        ],
                        [
                            'link' => 'http://thehuntingshop.co.uk/WebRoot/Store30/Shops/36680670-257a-40fe-b26c-f131e99aeaca/5A9D/2152/0EA6/385B/F6D8/0A48/3570/3806/1_ml.png',
                            'alt' => 'Horloge'
                        ]
                    ]
                ],
                'bids' => [
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '120'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '100'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '80'
                    ],
                    [
                        'user' => 'AnnieAntiek',
                        'amount' => '60'
                    ],
                    [
                        'user' => 'KeesAntiek',
                        'amount' => '400'
                    ]
                ]
            ]);
        }
        abort(404, 'Dit product is bij ons niet bekend.');
    }
}
