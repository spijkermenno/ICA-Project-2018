<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseItemRepository;

class productDescriptionIFrameController extends Controller
{
    public function index($product_id)
    {
        $productRepo = app()->make(DatabaseItemRepository::class);
        $itemDescription = $productRepo->getDescriptionById($product_id);

        if (isset($itemDescription[0])) {
            return view('product.description_iframe', ['description' => $itemDescription[0]->description]);
        }
    }
}
