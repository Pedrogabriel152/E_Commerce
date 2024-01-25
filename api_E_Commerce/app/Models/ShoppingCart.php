<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buyer_id',
        'total',
        'paid_out',
        'quantity_products',
    ];

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

}
