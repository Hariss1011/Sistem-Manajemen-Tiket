<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeTiket extends Model
{
    use HasFactory;

    protected $table = 'tipe_tikets';

    protected $fillable = [
        'nama',
    ];

    public function tikets(): HasMany
    {
        return $this->hasMany(
            Tiket::class,
            'tipe_tiket_id',
            'id'
        );
    }
}
