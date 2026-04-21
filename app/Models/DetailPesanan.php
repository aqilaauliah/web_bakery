<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'detail_pesanan';

    // Karena tidak ada kolom 'id', kita nonaktifkan auto-increment
    public $incrementing = false;

    // Menentukan Composite Primary Key
    protected $primaryKey = ['id_pesanan', 'id_produk'];

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah_pesan',
    ];

    /**
     * Penting: Laravel secara default tidak mendukung array pada primaryKey.
     * Fungsi ini ditambahkan agar Eloquent tahu cara mencari baris data 
     * berdasarkan dua kunci tersebut saat melakukan update atau delete.
     */
    protected function setKeysForSaveQuery($query)
    {
        $query->where('id_pesanan', $this->getAttribute('id_pesanan'))
              ->where('id_produk', $this->getAttribute('id_produk'));

        return $query;
    }

    /**
     * Relasi ke Produk (N:1)
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Relasi ke Pesanan (N:1)
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}