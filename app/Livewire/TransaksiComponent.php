<?php

namespace App\Livewire;

use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class TransaksiComponent extends Component
{
    use WithPagination;

    public $addPage, $lihatPage, $showModal = false;
    public $nama, $ponsel, $alamat, $tanggal_kembali, $tanggal_pesan, $mobil_id, $harga, $total, $biaya_driver, $dp_bayar, $denda, $pembayaran, $days_late, $kode_booking, $snap_token, $manipulated_date;


    public function showRingkasanModal()
    {
        $this->showModal = true;
        $this->dispatch('showModal');
    }
    public function mount()
    {
        $this->manipulated_date = now()->format('Y-m-d'); // Inisialisasi nilai awal
    }

    public function render()
    {
        $data['transaksi'] = Transaksi::with('mobil')->latest()->first(); // Atau Anda bisa sesuaikan kondisinya
        $data['mobil'] = Mobil::where('status_mobil', 'ready')->paginate(10000000);

        return view('livewire.transaksi-component', $data);
    }
    public function create($id, $harga)
    {
        $this->mobil_id = $id;
        $this->harga = $harga;
        $this->addPage = true;
    }

    public function hitung()
    {
        if ($this->tanggal_pesan && $this->tanggal_kembali) {
            $tanggal_pesan = Carbon::parse($this->tanggal_pesan);
            $tanggal_kembali = Carbon::parse($this->tanggal_kembali);

            // Menghitung lama sewa dalam hari
            $lama = $tanggal_pesan->diffInDays($tanggal_kembali);

            if ($lama <= 0) {
                $this->total = 0;
                session()->flash('error', 'Tanggal kembali harus setelah tanggal pesan!');
                return;
            }

            // Menambahkan biaya driver jika ada
            $harga = $this->harga;
            if ($this->biaya_driver === 'With-Drive') {
                $harga += 50000; // Biaya tambahan jika ada driver
            }

            // Menghitung total harga
            $this->total = $lama * $harga;

            // Menghitung DP (50% dari total jika bayar DP, atau 0 jika bayar langsung)
            if ($this->pembayaran === 'Bayar DP') {
                $this->dp_bayar = $this->total * 0.5; // 50% dari total harga
            } else {
                $this->dp_bayar = 0; // Bayar langsung, DP = 0
            }
        } else {
            $this->total = 0;
            session()->flash('error', 'Tanggal pesan dan tanggal kembali harus diisi!');
        }
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'ponsel' => 'required',
            'alamat' => 'required',
            'tanggal_pesan' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pesan'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'ponsel.required' => 'Ponsel tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'tanggal_pesan.required' => 'Tanggal Pesan tidak boleh kosong!',
            'tanggal_kembali.required' => 'Tanggal Kembali tidak boleh kosong!',
            'tanggal_kembali.after' => 'Tanggal kembali harus setelah tanggal pesan!'
        ]);

        $tanggal_pesan = Carbon::parse($this->tanggal_pesan);
        $tanggal_kembali = Carbon::parse($this->tanggal_kembali);

        // Periksa apakah mobil tersedia
        $cari = Transaksi::where('mobil_id', $this->mobil_id)
            ->where('status', '!=', 'SELESAI')
            ->where(function ($query) use ($tanggal_pesan, $tanggal_kembali) {
                $query->whereBetween('tanggal_pesan', [$tanggal_pesan, $tanggal_kembali])
                    ->orWhereBetween(DB::raw("tanggal_pesan + (tanggal_kembali - tanggal_pesan)"), [$tanggal_pesan, $tanggal_kembali])
                    ->orWhere(function ($query) use ($tanggal_pesan, $tanggal_kembali) {
                        $query->where('tanggal_pesan', '<=', $tanggal_pesan)
                            ->where(DB::raw("tanggal_pesan + (tanggal_kembali - tanggal_pesan)"), '>=', $tanggal_kembali);
                    });
            })->exists();

        if ($cari) {
            session()->flash('error', 'Mobil sudah ada yang memesan pada tanggal tersebut!');
            return;
        }

        $this->hitung();

        // Simpan transaksi ke database
        $transaksi = new Transaksi([
            'mobil_id' => $this->mobil_id,
            'nama' => $this->nama,
            'ponsel' => $this->ponsel,
            'alamat' => $this->alamat,
            'tanggal_pesan' => $this->tanggal_pesan,
            'tanggal_kembali' => $this->tanggal_kembali,
            'biaya_driver' => $this->biaya_driver,
            'dp_bayar' => $this->dp_bayar,
            'total' => $this->total,
            'denda' => 0,
            'status' => 'WAIT',
            'kode_booking' => 'book-' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
        ]);

        // Simpan transaksi terlebih dahulu
        $transaksi->save();
        $transaksi->refresh();
    }
    public function resetInputFields()
    {
        $this->nama = null;
        $this->ponsel = null;
        $this->alamat = null;
        $this->tanggal_pesan = null;
        $this->tanggal_kembali = null;
        $this->mobil_id = null;
        $this->harga = null;
        $this->total = null;
        $this->addPage = false;
        $this->lihatPage = false;
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            session()->flash('error', 'Data transaksi tidak ditemukan!');
            return;
        }

        $transaksi->delete();

        session()->flash('success', 'Data transaksi berhasil dihapus!');
        $this->dispatch('closeModal');

        return redirect('/homepage');
    }
}
