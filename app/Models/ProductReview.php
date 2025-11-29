<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';

    protected $fillable = [
        'product_id',
        'reviewer_name',
        'reviewer_phone',
        'reviewer_email',
        'rating',
        'comment',
        'email_sent',
        'email_sent_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
