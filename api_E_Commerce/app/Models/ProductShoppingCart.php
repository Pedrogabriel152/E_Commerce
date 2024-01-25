<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'product_shopping_cart';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'shopping_cart_id',
        'amount'
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function shopping_cart(){
        return $this->hasOne(ShoppingCart::class, 'id', 'shopping_cart');
    }
}
