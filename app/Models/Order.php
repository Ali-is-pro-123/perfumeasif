<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'processing', 'shipped', 'completed', 'cancelled'];

    protected $fillable = [
        'order_number',
        'customer_name',
        'email',
        'phone',
        'address',
        'city',
        'notes',
        'status',
        'subtotal',
        'shipping',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }
}
