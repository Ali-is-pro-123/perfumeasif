<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'category',
        'badge',
        'notes',
        'description',
        'price',
        'size',
        'image',
        'is_featured',
        'is_carousel',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_carousel' => 'boolean',
        ];
    }

    public function categoryModel(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categoryName(): string
    {
        return $this->categoryModel?->name ?: ($this->category ?: 'Fragrance');
    }
}
