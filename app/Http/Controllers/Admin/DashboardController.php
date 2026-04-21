<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Penjualan (Hanya yang status bayarnya 'lunas')
        $totalPenjualan = Pesanan::where('status_bayar', 'lunas')->sum('total_bayar');

        // 2. Pesanan Baru Hari Ini
        $pesananHariIni = Pesanan::whereDate('tgl_pesan', Carbon::today())->count();

        // 3. Pesanan yang Belum Lunas (Perlu tindak lanjut)
        $pesananBelumLunas = Pesanan::where('status_bayar', 'belum_lunas')->count();

        // 4. Total Pelanggan Terdaftar
        $totalPelanggan = Pelanggan::count();

        // 5. Total Produk (Menu Roti)
        $totalProduk = Produk::count();

        // 6. Data Pesanan Terbaru (Limit 5 untuk tabel di dashboard)
        $pesananTerbaru = Pesanan::with(['pelanggan', 'karyawan'])
            ->orderBy('tgl_pesan', 'desc')
            ->take(5)
            ->get();

        // Mengirim data ke view admin/dashboard.blade.php
        return view('admin.dashboard', compact(
            'totalPenjualan',
            'pesananHariIni',
            'pesananBelumLunas',
            'totalPelanggan',
            'totalProduk',
            'pesananTerbaru'
        ));
    }
}