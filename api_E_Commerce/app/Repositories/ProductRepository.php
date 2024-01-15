<?php

namespace App\Repositories;

use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function create(array $data){
        return DB::transaction(function () use ($data) {
            $newProduct = Product::create([
                'product' => $data['product'],
                'price' => $data['price'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'available_by_id' => intval($data['available_by_id']),
            ]); 

            $newProduct->image = ImageService::saveImage($data, 'products', $newProduct->id);
            $newProduct->save();

            return $newProduct;
        });
    }
}