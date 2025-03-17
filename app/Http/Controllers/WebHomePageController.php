<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class WebHomePageController extends Controller
{
    public function webhomepage()
    {
        // Mengambil semua data mobil dari database
        $mobils = Mobil::where('status_mobil', 'ready')->get();
        return view('web.homepage', compact('mobils'));
    }

    private function hitungTotal($harga, $biaya_driver, $tanggal_pesan, $tanggal_kembali, $pembayaran)
    {
        $tanggal_pesan = Carbon::parse($tanggal_pesan);
        $tanggal_kembali = Carbon::parse($tanggal_kembali);

        // Menghitung lama sewa dalam hari
        $lama = $tanggal_pesan->diffInDays($tanggal_kembali);

        if ($lama <= 0) {
            throw new \Exception('Tanggal kembali harus setelah tanggal pesan!');
        }

        // Menghitung biaya driver jika ada
        $biaya_driver = ($biaya_driver === 'With-Drive') ? 50000 : 0; // Biaya driver yang benar

        // Menambahkan biaya driver pada harga jika ada
        $total = ($lama * $harga) + $biaya_driver;

        // Menghitung DP (50% jika bayar DP, 0 jika bayar langsung)
        $dp_bayar = ($pembayaran === 'Bayar DP') ? $total * 0.5 : 0;

        return [
            'total' => $total,
            'dp_bayar' => $dp_bayar
        ];
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'nama' => 'required|string|max:255',
            'ponsel' => 'required|string|max:15',
            'alamat' => 'required|string',
            'tanggal_pesan' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pesan',
            'pembayaran' => 'required|in:Bayar DP,Bayar Langsung',
            'biaya_driver' => 'required|in:With-Drive,Without-Drive',  // Validasi biaya_driver
        ]);

        $mobil = Mobil::findOrFail($validated['mobil_id']);

        // Pengecekan ketersediaan mobil
        $tanggal_pesan = Carbon::parse($validated['tanggal_pesan']);
        $tanggal_kembali = Carbon::parse($validated['tanggal_kembali']);

        // Cek apakah mobil sudah dipesan pada rentang tanggal tersebut
        $mobilTersedia = Transaksi::where('mobil_id', $mobil->id)
            ->where(function ($query) use ($tanggal_pesan, $tanggal_kembali) {
                // Mengecek jika pemesanan lama tumpang tindih dengan pemesanan baru
                $query->whereBetween('tanggal_pesan', [$tanggal_pesan, $tanggal_kembali])
                    ->orWhereBetween('tanggal_kembali', [$tanggal_pesan, $tanggal_kembali])
                    ->orWhere(function ($query) use ($tanggal_pesan, $tanggal_kembali) {
                        $query->where('tanggal_pesan', '<=', $tanggal_pesan)
                            ->where('tanggal_kembali', '>=', $tanggal_kembali);
                    });
            })
            ->exists();

        if ($mobilTersedia) {
            // Jika mobil sudah dipesan pada rentang tanggal yang diberikan, kembalikan error
            return back()->withErrors(['tanggal_kembali' => 'Mobil sudah dipesan pada tanggal tersebut. Silakan pilih tanggal lain.'])->withInput();
        }

        // Perhitungan total harga dan DP
        try {
            $hargaDetails = $this->hitungTotal($mobil->harga, $validated['biaya_driver'] ?? 'Without-Drive', $validated['tanggal_pesan'], $validated['tanggal_kembali'], $validated['pembayaran']);
        } catch (\Exception $e) {
            return back()->withErrors(['tanggal_kembali' => $e->getMessage()])->withInput();
        }

        // Simpan transaksi
        $transaksi = new Transaksi([
            'mobil_id' => $validated['mobil_id'],
            'nama' => $validated['nama'],
            'ponsel' => $validated['ponsel'],
            'alamat' => $validated['alamat'],
            'tanggal_pesan' => $validated['tanggal_pesan'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'biaya_driver' => $validated['biaya_driver'] ?? 'Without-Drive',
            'dp_bayar' => $hargaDetails['dp_bayar'],
            'total' => $hargaDetails['total'],
            'denda' => 0,
            'status' => 'WAIT',
            'kode_booking' => 'book-' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
        ]);

        // Simpan transaksi terlebih dahulu
        $transaksi->save();

        // Menyimpan Snap Token dari Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $gross_amount = $hargaDetails['total']; // Default untuk Bayar Langsung
        if ($validated['pembayaran'] === 'Bayar DP') {
            $gross_amount = $hargaDetails['dp_bayar']; // Jika DP, ambil DP yang sudah dihitung
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_booking,
                'gross_amount' => $gross_amount,
            ],
            'customer_details' => [
                'first_name' => $validated['nama'],
                'phone' => $validated['ponsel'],
                'address' => $validated['alamat'],
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaksi->snap_token = $snapToken;
            $transaksi->save();

            // Menyimpan transaksi di session
            session(['transaksi' => $transaksi]);

            // Kembalikan snap_token dan order_id
            return response()->json(['snap_token' => $snapToken, 'order_id' => $transaksi->kode_booking]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mendapatkan Snap Token.'], 500);
        }
    }

    public function orderSuccess(Request $request)
    {
        // Pastikan transaksi ada di session
        if (!session()->has('transaksi')) {
            return redirect()->route('home')->withErrors(['error' => 'Transaksi tidak ditemukan.']);
        }

        $transaksi = session('transaksi');
        $transaksi->status = 'PROSES';
        $transaksi->save();

        // Kirim data transaksi ke view
        return view('web/order-success', compact('transaksi'));
    }
}
