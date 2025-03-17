<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use PhpParser\Node\Expr\FuncCall;

class LihatTransaksi extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[On('lihat-transaksi')]
    public function render()
    {
        $data['transaksi'] = Transaksi::paginate(10000000000000000);
        return view('livewire.lihat-transaksi', $data);
    }
    public function proses($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->update([
            'status' => 'PROSES'
        ]);
        session()->flash('success', 'Berhasil proses data!');
    }
    public function selesai($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->update([
            'status' => 'SELESAI'
        ]);
        session()->flash('success', 'Berhasil proses data');
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
    }
}
