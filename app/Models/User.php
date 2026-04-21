<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tambahkan ini jika nama tabelmu di database adalah 'user' (singular)
    protected $table = 'user';

    // Menentukan primary key karena bukan 'id' (default Laravel)
    protected $primaryKey = 'id_user';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast atribut ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi 1:1 ke Pelanggan
     * Menghubungkan id_user di tabel user dengan id_user di tabel pelanggan
     */
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    /**
     * Beritahu Laravel untuk menggunakan 'username' sebagai identifier otentikasi utama
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Helper untuk mengecek role
     */
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }
}