<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    // Menentukan nama tabel (singular)
    protected $table = 'karyawan';

    // Menentukan primary key sesuai ERD
    protected $primaryKey = 'id_karyawan';

    /**
     * Atribut yang dapat diisi secara massal.
     * Sesuai dengan skema: nama, no_tlp, alamat
     */
    protected $fillable = [
        'nama',
        'no_tlp',
        'alamat',
    ];

    /**
     * Relasi ke Pesanan (1:N)
     * Satu karyawan bisa memiliki banyak pesanan yang diajukan/diurus
     */
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_karyawan', 'id_karyawan');
    }
}