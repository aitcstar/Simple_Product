<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id', 'variations', 'price'
    ];

    protected $casts = [
        'variations' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
