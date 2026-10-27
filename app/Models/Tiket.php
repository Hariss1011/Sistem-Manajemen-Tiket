<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'tipe_tiket_id',
        'harga',
        'stok',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'stok' => 'integer',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function tipeTiket(): BelongsTo
    {
        return $this->belongsTo(TipeTiket::class, 'tipe_tiket_id');
    }

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class, 'tiket_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class,
            'detail_orders',
            'tiket_id',
            'order_id'
        )->withPivot([
            'jumlah',
            'subtotal_harga',
        ])->withTimestamps();
    }
}
