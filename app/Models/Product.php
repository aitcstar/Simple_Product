<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'type', 'name', 'price', 'original_price','discount','image' ,'is_featured', 'ai_suggested'
    ];

    protected $casts = [
        'name' => 'array',
        'is_featured' => 'boolean',
        'ai_suggested' => 'boolean'
    ];

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }
}
