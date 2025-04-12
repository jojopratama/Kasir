<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data['title'] = 'Penjualan';
        $data['subtitle'] = 'Index';

        $data['totalPenjualan'] = Penjualan::sum('TotalHarga');
        $data['totalProduk'] = Produk::count();
        $data['totalStok'] = Produk::sum('stok');
        $data['totalPengguna'] = User::count();
        return view('admin.dashboard',$data);
    }
}
