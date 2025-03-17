<div class="col-sm-12 col-xl-6">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Add Transaksi</h6>
        <form>
            <div class="mb-3">
                <input type="hidden" id="manipulated_date" wire:model="manipulated_date">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" wire:model="nama" id="nama" value="{{ @old('nama') }}">
                @error('nama')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ponsel" class="form-label">Nomor Ponsel Pemesan</label>
                <input type="text" class="form-control" wire:model="ponsel" id="ponsel"
                    value="{{ @old('ponsel') }}">
                @error('ponsel')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Pemesan</label>
                <input type="text" class="form-control" wire:model="alamat" id="alamat"
                    value="{{ @old('alamat') }}">
                @error('alamat')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_pesan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" wire:change="hitung" wire:model="tanggal_pesan"
                    id="tanggal_pesan" value="{{ @old('tanggal_pesan') }}">
                @error('tanggal_pesan')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" wire:change="hitung" wire:model="tanggal_kembali"
                    id="tanggal_kembali" value="{{ @old('tanggal_kembali') }}">
                @error('tanggal_kembali')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                <select wire:change="hitung" wire:model="pembayaran" id="pembayaran" class="form-control">
                    <option value="">-- Pilih Pembayaran --</option>
                    <option value="Bayar DP">Bayar DP</option>
                    <option value="Bayar Langsung">Bayar Langsung</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="biaya_driver" class="form-label">Pilih Supir</label>
                <select wire:change="hitung" wire:model="biaya_driver" id="biaya_driver" class="form-control">
                    <option value="">-- Pilih Supir --</option>
                    <option value="With-Drive">With Driver</option>
                    <option value="Self-Drive">Self Drive</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="dp_bayar" class="form-label">DP Pembayaran</label>
                <input type="text" class="form-control" id="dp_bayar" value="{{ $dp_bayar }}" disabled>
            </div>

            <div class="mb-3">
                Total Harga: Rp {{ number_format($total, 0, ',', '.') }}
            </div>
            <button type="button" class="btn btn-primary" wire:click="store">Simpan</button>
        </form>
    </div>
</div>
