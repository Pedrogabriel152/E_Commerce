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

    public function update(array $data, Product $product) {
        return DB::transaction(function () use ($data, $product) {
            $product->product = $data['product'];
            $product->price = $data['price'];
            $product->amount = $data['amount'];
            $product->description = $data['description'];
            $product->available_by_id = intval($data['available_by_id']);
            
            if(array_key_exists('image', $data)) {
                $product->image = ImageService::saveImage($data, 'products', $product->id);
            }
            
            $product->save();

            return $product;
        });
    }

    public function delete(Product $product) {
        $product->active = false;
        return $product->save();
    }
}