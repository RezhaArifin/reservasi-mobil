<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['mobil'] = Mobil::count();
        $data['user'] = User::count();
        
        // Konversi 'total' ke numeric dan hitung sum-nya
        $data['transaksi'] = Transaksi::where('status', 'SELESAI')
                              ->select(DB::raw('SUM(CAST(total AS DECIMAL)) as total'))
                              ->first()->total;
    
        return view('home', $data);
    }
}
