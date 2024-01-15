<?php

namespace App\Services;

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

    public function update(array $updateProduct) {
        try {
            VerificationService::verifyFields($this->requiredFileds_, null , $updateProduct);



        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}