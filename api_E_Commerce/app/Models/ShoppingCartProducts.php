<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartProducts extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'shopping_cart',
        'amount'
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function shopping_cart(){
        return $this->hasOne(ShoppingCart::class, 'id', 'shopping_cart');
    }
}
