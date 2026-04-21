<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pembayaran';

    // Primary Key tabel ini
    protected $primaryKey = 'id_pembayaran';

    /**
     * Atribut yang dapat diisi secara massal.
     * id_pesanan berfungsi sebagai Foreign Key yang menghubungkan ke tabel pesanan.
     */
    protected $fillable = [
        'id_pesanan',
        'tgl_pembayaran',
        'jumlah_bayar',
        'metode_pembayaran',
    ];

    /**
     * Relasi Balik ke Pesanan (1:1)
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}