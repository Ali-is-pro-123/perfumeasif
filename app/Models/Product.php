<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
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
}
