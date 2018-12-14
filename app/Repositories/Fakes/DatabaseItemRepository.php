<?php

namespace App\Repositories\Fakes;

use App\Repositories\DatabaseRepository;
use App\Repositories\Contracts\ItemRepository;

/**
 * Class DatabaseItemRepository
 * @package App\Repositories\Fakes
 */
class DatabaseItemRepository extends DatabaseRepository implements ItemRepository
{
    /**
     * @return array
     */
    public function getAll()
    {
        return [
            [
                'id' => 1,
                'title' => 'Stabiele drum/pianokruk, nieuw, in hoogte verstelbaar',
                'description' => 'Stabiele drum/pianokruk, nieuw, in hoogte verstelbaar (4 standen). Onderstel eenvoudig inklapbaar, zitting eenvoudig te demonteren (vleugelmoer). De kruk op de foto is een voorbeeld, de aangeboden kruk zit nog in de verpakking',
                'start_price' => 1.00,
                'selling_price' => null,
                'payment_method' => 'Bank/Giro',
                'payment_instruction' => 'Overschrijving moet ontvangen zijn binnen 10 dagen na verkoop',
                'duration' => 7,
                'start' => '2004-05-23T14:25:10',
                'end' => '2004-05-30T14:25:10',
                'auction_closed' => 1,
                'shipping_cost' => 5.50,
                'seller' => 'joost',
                'buyer' => null
            ],
            [
                'id' => 2,
                'title' => 'Yamaha Pf80 Electric Piano',
                'description' => 'Yamaha Pf80 Electric Piano with a foot-pedal. In great working condition, with many different sounds and options.',
                'start_price' => 1.00,
                'selling_price' => 70.00,
                'payment_method' => 'Contant',
                'payment_instruction' => 'Ophalen bij verkoper',
                'duration' => 7,
                'start' => '2018-11-28T17:25:10',
                'end' => '2005-12-5T17:25:10',
                'auction_closed' => 0,
                'shipping_cost' => 0.00,
                'seller' => 'menno',
                'buyer' => null
            ]
        ];
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function getById(int $id)
    {
        $items = $this->getAll();

        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }

        return null;
    }

    public function getMostPopularItems(int $amount)
    {
        return [
            [
                'id' => 1,
                'title' => 'Stabiele drum/pianokruk, nieuw, in hoogte verstelbaar',
                'description' => 'Stabiele drum/pianokruk, nieuw, in hoogte verstelbaar (4 standen). Onderstel eenvoudig inklapbaar, zitting eenvoudig te demonteren (vleugelmoer). De kruk op de foto is een voorbeeld, de aangeboden kruk zit nog in de verpakking',
                'start_price' => 1.00,
                'selling_price' => null,
                'payment_method' => 'Bank/Giro',
                'payment_instruction' => 'Overschrijving moet ontvangen zijn binnen 10 dagen na verkoop',
                'duration' => 7,
                'start' => '2004-05-23T14:25:10',
                'end' => '2004-05-30T14:25:10',
                'auction_closed' => 1,
                'shipping_cost' => 5.50,
                'seller' => 'joost',
                'buyer' => null
            ],
            [
                'id' => 2,
                'title' => 'Yamaha Pf80 Electric Piano',
                'description' => 'Yamaha Pf80 Electric Piano with a foot-pedal. In great working condition, with many different sounds and options.',
                'start_price' => 1.00,
                'selling_price' => 70.00,
                'payment_method' => 'Contant',
                'payment_instruction' => 'Ophalen bij verkoper',
                'duration' => 7,
                'start' => '2018-11-28T17:25:10',
                'end' => '2005-12-5T17:25:10',
                'auction_closed' => 0,
                'shipping_cost' => 0.00,
                'seller' => 'menno',
                'buyer' => null
            ]
        ];
    }

    public function getAllBetween(int $from, int $to)
    {
        // TODO: Implement getAllBetween() method.
    }

    public function getSoonEndingItems(int $amount)
    {
        // TODO: Implement getSoonEndingItems() method.
    }
}
