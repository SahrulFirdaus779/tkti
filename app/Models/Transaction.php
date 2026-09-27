<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public const PEMASUKAN = 'pemasukan';
    public const PENGELUARAN = 'pengeluaran';

    /**
     * Daftar kategori untuk setiap jenis transaksi.
     */
    public const CATEGORIES = [
        self::PEMASUKAN => ['Gaji', 'Uang Saku', 'Bonus', 'Lainnya'],
        self::PENGELUARAN => ['Makanan', 'Transportasi', 'Belanja', 'Pendidikan', 'Hiburan', 'Lainnya'],
    ];

    protected $fillable = [
        'user_id',
        'type',
        'category',
        'amount',
        'description',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
        ];
    }

    /**
     * Transaksi dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPemasukan(): bool
    {
        return $this->type === self::PEMASUKAN;
    }

    /**
     * Format angka menjadi Rupiah, contoh: Rp1.250.000
     */
    public static function rupiah($amount): string
    {
        return 'Rp' . number_format((float) $amount, 0, ',', '.');
    }
}
