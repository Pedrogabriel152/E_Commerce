<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product',
        'price',
        'amount',
        'description',
        'image',
        'available_by_id',
        'active',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'available_by_id', 'id');
    }
}
