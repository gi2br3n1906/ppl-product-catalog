<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'seller_id',
        'category',
        'image',
    ];

    /**
     * Relasi ke User (Seller)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
