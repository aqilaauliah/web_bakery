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
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'owner') {
                abort(403, 'Unauthorized. Admin access only.');
            }
            return $next($request);
        });
    }
    public function index()
    {
        // Menggunakan data dummy untuk sekarang
        // Nanti bisa di-replace dengan query database sebenarnya
        
        $totalPenjualan = 45200000; // Dummy data
        $pesananHariIni = 84;
        $pesananBelumLunas = 247;
        $totalPelanggan = 542;
        $totalProduk = 256;
        $pesananTerbaru = [];

        // Jika ada models dan tables, uncomment code di bawah:
        /*
        try {
            $totalPenjualan = Pesanan::where('status_bayar', 'lunas')->sum('total_bayar');
            $pesananHariIni = Pesanan::whereDate('tgl_pesan', Carbon::today())->count();
            $pesananBelumLunas = Pesanan::where('status_bayar', 'belum_lunas')->count();
            $totalPelanggan = Pelanggan::count();
            $totalProduk = Produk::count();
            $pesananTerbaru = Pesanan::with(['pelanggan', 'karyawan'])
                ->orderBy('tgl_pesan', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Gunakan dummy data jika ada error
        }
        */

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