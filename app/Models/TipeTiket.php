<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeTiket extends Model
{
    protected $table = 'tipe_tikets';

    protected $fillable = [
        'nama',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'tipe_tiket_id', 'id');
    }
}
