<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService 
{
    private $productRepository_;
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

            $newProduct = $this->productRepository_->create();

        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }
}