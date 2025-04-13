<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Bayar;
use App\Models\User;
use App\Models\Penjualan;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $subtitle = Auth::user()->role === 'admin' ? 'Admin' : 'Petugas';

        $totalPenjualan = Penjualan::count();
        $totalPetugasKasir = User::where('role', 'petugas')->count();
        $totalProduk = Produk::count();

        // Calculate weekly income from Bayar table where StatusBayar is 'Lunas'
        $startDate = Carbon::now()->subDays(7)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $weeklyIncome = Bayar::where('StatusBayar', 'Lunas')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('TotalBayar');

        if (Auth::user()->role === "admin") {
            return view('admin.dashboard', compact(
                'title',
                'subtitle',
                'totalPenjualan',
                'weeklyIncome',
                'totalPetugasKasir',
                'totalProduk'
            ));
        } else if (Auth::user()->role === "petugas") {
            return view('kasir.dashboard', compact('title', 'subtitle'));
        }
    }
}
