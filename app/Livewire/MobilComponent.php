<?php

namespace App\Livewire;

use App\Models\Mobil;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

use function PHPUnit\Framework\returnSelf;

class MobilComponent extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $addPage, $editPage = false;
    public $nopolisi, $merk, $jenis, $harga ,$kapasitas, $status_mobil, $foto, $id;
    public function render()
    {
        $data['mobil'] = Mobil::paginate(10000000);
        return view('livewire.mobil-component', $data);
    }
    public function create()
    {
        $this->addPage = true;
    }
    public function store()
    {
        $this->validate([
            'nopolisi' => 'required',
            'merk' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
            'kapasitas' => 'required',
            'foto' => 'required|image'
        ], [
            'nopolisi.required' => 'Nomor Polisi tidak boleh kosong!',
            'merk.required' => 'Merk tidak boleh kosong!',
            'jenis.required' => 'Jenis Mobil tidak boleh kosong!',
            'harga.required' => 'Harga tidak boleh kosong!',
            'kapasitas.required' => 'Kapasitas Mobil tidak boleh kosong!',
            'foto.required' => 'Foto Mobil tidak boleh kosong!',
            'foto.image' => 'Foto dalam format image!'
        ]);

        $this->foto->storeAs('public/mobil', $this->foto->hashName());
        Mobil::create([
            'user_id' => auth()->user()->id,
            'nopolisi' => $this->nopolisi,
            'merk' => $this->merk,
            'jenis' => $this->jenis,
            'harga' => $this->harga,
            'kapasitas' => $this->kapasitas,
            'foto' => $this->foto->hashName()
        ]);
        session()->flash('success', 'Berhasil simpan data!');
        $this->reset();
    }
    public function edit($id)
    {
        $this->editPage = true;
        $this->id = $id;
        $mobil = Mobil::find($id);
        $this->nopolisi = $mobil->nopolisi;
        $this->merk = $mobil->merk;
        $this->jenis = $mobil->jenis;
        $this->harga = $mobil->harga;
        $this->kapasitas = $mobil->kapasitas;
    }
    public function update()
    {
        $mobil = Mobil::find($this->id);
        if (empty($this->foto)) {
            $mobil->update([
                'user_id' => auth()->user()->id,
                'nopolisi' => $this->nopolisi,
                'merk' => $this->merk,
                'jenis' => $this->jenis,
                'harga' => $this->harga,
                'kapasitas' => $this->kapasitas
            ]);
        } else {
            // unlink(public_path('storage/mobil/' . $mobil->foto));
            unlink('storage/mobil/' . $mobil->foto);
            $this->foto->storeAs('public/mobil', $this->foto->hashName());
            $mobil->update([
                'user_id' => auth()->user()->id,
                'nopolisi' => $this->nopolisi,
                'merk' => $this->merk,
                'jenis' => $this->jenis,
                'harga' => $this->harga,
                'kapasitas' => $this->kapasitas,
                'foto' => $this->foto->hashName()
            ]);
        }
        session()->flash('success', 'Berhasil Diubah!');
        $this->reset();
    }
    public function destroy($id)
    {
        $mobil = Mobil::find($id);
        // unlink(public_path('storage/mobil/' . $mobil->foto));
        unlink('storage/mobil/' . $mobil->foto);
        $mobil->delete();
        session()->flash('success', 'Berhasil dihapus');
        $this->reset();
    }
    public function Ready($id){
        $transaksi = Mobil::find($id);
        $transaksi->update([
            'status_mobil' => 'ready'
        ]);
        session()->flash('success', 'Berhasil proses data!');
    }
    public function Booking($id){
        $transaksi = Mobil::find($id);
        $transaksi->update([
            'status_mobil' => 'booking'
        ]);
        session()->flash('success', 'Berhasil proses data');
    }
    public function Maintenance($id){
        $transaksi = Mobil::find($id);
        $transaksi->update([
            'status_mobil' => 'maintenance'
        ]);
        session()->flash('success', 'Berhasil proses data');
    }
}
