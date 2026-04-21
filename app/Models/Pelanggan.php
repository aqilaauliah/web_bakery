<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Menentukan nama tabel karena bukan bentuk jamak bahasa Inggris (bukan pelanggans)
    protected $table = 'pelanggan';

    // Menentukan primary key sesuai ERD
    protected $primaryKey = 'id_pelanggan';

    /**
     * Atribut yang dapat diisi secara massal.
     * id_user disimpan di sini sebagai Foreign Key untuk relasi ke tabel User.
     */
    protected $fillable = [
        'id_user',
        'nama',
        'no_tlp',
        'alamat',
    ];

    /**
     * Relasi Balik ke User (Satu profil pelanggan dimiliki oleh satu User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Pesanan (Satu pelanggan bisa punya banyak pesanan)
     */
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }
}