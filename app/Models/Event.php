<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected function casts(): array
    {
        return [
            'tanggal_waktu' => 'datetime',
        ];
    }

    public function tikets(): HasMany
    {
        return $this->hasMany(Tiket::class, 'event_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'event_id');
    }


    /**
     * URL gambar event.
     * Mendukung URL eksternal, path relatif dari public,
     * dan nama file yang diunggah.
     */
    public function getGambarUrlAttribute(): string
    {
        $gambar = trim((string) $this->gambar);

        if ($gambar === '') {
            return asset('images/placeholder-event.svg');
        }

        // URL eksternal.
        if (Str::startsWith($gambar, ['https://', 'http://'])) {
            return $gambar;
        }

        // Hilangkan slash di awal path.
        $gambar = ltrim($gambar, '/');

        // Jika path sudah diawali images/events/, gunakan langsung.
        if (Str::startsWith($gambar, 'images/events/')) {
            return asset($gambar);
        }

        // Jika hanya nama file, tambahkan folder gambar event.
        return asset('images/events/' . $gambar);
    }

    /**
     * Menentukan apakah event sudah melewati tanggal pelaksanaannya.
     */
    public function getIsPastAttribute(): bool
    {
        return $this->tanggal_waktu !== null
            && $this->tanggal_waktu->isPast();
    }

    /**
     * Hanya mengambil event yang belum lewat.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tanggal_waktu', '>=', now());
    }

    /**
     * Mencari event berdasarkan judul atau nama lokasi.
     */
    public function scopeSearch(
        Builder $query,
        ?string $term
    ): Builder {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($term) {
            $builder
                ->where('judul', 'like', '%' . $term . '%')
                ->orWhereHas('lokasi', function (Builder $lokasiQuery) use ($term) {
                    $lokasiQuery->where(
                        'nama_lokasi',
                        'like',
                        '%' . $term . '%'
                    );
                });
        });
    }
}
