<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'tanggal_waktu',
        'lokasi_id',
        'kategori_id',
        'gambar',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /** URL gambar: mendukung URL penuh, nama file upload, dan placeholder. */
    public function getGambarUrlAttribute(): string
    {
        if (! $this->gambar) {
            return asset('images/placeholder-event.svg');
        }

        if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
            return $this->gambar;
        }

        return asset('images/events/' . $this->gambar);
    }

    public function getIsPastAttribute(): bool
    {
        return $this->tanggal_waktu->isPast();
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tanggal_waktu', '>=', now());
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('judul', 'like', "%{$term}%")
                ->orWhereHas('lokasi', fn(Builder $l) => $l->where('nama_lokasi', 'like', "%{$term}%"));
        });
    }
}
