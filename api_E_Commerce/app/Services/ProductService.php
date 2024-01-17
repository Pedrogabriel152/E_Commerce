<?php

namespace App\Services;

use App\Models\Product;
use ErrorException;
use App\Repositories\ProductRepository;

class ProductService 
{
    private ProductRepository $productRepository_;
    private array $requiredFileds_ = [
        'product',
        'price',
        'amount',
        'description',
        'image',
        'available_by_id'
    ];

    public function __construct()
    {
        $this->productRepository_ = new ProductRepository();
    }

    public function create(array $product) {
        try {

            VerificationService::verifyFields($this->requiredFileds_, null , $product);

            $newProduct = $this->productRepository_->create($product);

            if(!$newProduct) throw new ErrorException('An error has occurred', 500);

            return [
                'message' => 'Product created successfully',
                'code' => 200,
                'product' => $newProduct
            ];

        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }

    public function update(int $id, array $data) {
        try {
            $product = Product::find($id);

            if(!$product) throw new ErrorException('product not found', 404);

            if(auth()->user()->id != $product->available_by_id) throw new ErrorException('permission denied', 403);

            $data['available_by_id'] = $product->available_by_id;

            VerificationService::verifyFields($this->requiredFileds_, null , $data);

            $updateProduct = $this->productRepository_->update($data, $product);

            if(!$updateProduct) throw new ErrorException('An error has occurred', 500);

            return [
                'message' => 'Product updated successfully',
                'code' => 200,
                'product' => $updateProduct
            ];

        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }

    public function delete(int $id) {
        try {
            $product = Product::find($id);

            if(!$product) throw new ErrorException('product not found', 404);

            if(auth()->user()->id != $product->available_by_id) throw new ErrorException('permission denied', 403);

            $this->productRepository_->delete($product);

            return [
                'message' => 'Product deleted successfully',
                'code' => 200
            ];
            
        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }
}