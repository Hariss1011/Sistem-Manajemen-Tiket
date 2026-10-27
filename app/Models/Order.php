<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'order_date',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id')
            ->withTrashed();
    }

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class, 'order_id');
    }

    public function tikets(): BelongsToMany
    {
        return $this->belongsToMany(
            Tiket::class,
            'detail_orders',
            'order_id',
            'tiket_id'
        )->withPivot([
            'jumlah',
            'subtotal_harga',
        ])->withTimestamps();
    }
}
