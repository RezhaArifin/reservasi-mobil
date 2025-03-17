<div class="col-sm-12 col-xl-12">
    <div class="bg-light rounded h-100 p-4">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
        @endif
        <h6 class="mb-4">Data Laporan Transaksi</h6>
        <div class="row">
            <div class="col-md-4">
                <input type="date" wire:model="tanggal1" class="form-control" placeholder="Tanggal">
            </div>
            <div class="col-md-1">
                Sampai Dengan
            </div>
            <div class="col-md-4">
                <input type="date" wire:model="tanggal2" class="form-control" placeholder="Tanggal">
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-primary" wire:click="cari">Search </button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No Booking</th>
                    <th scope="col">No Polisi</th>
                    <th scope="col">Nama Pemesan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal Pesan</th>
                    <th scope="col">Tanggal Kembali</th>
                    <th scope="col">B.DP</th>
                    <th scope="col">Denda</th>
                    <th scope="col">Driver</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $data)
                    <tr>
                        <td>{{ $data->kode_booking }}</td>
                        <td>{{ $data->mobil->nopolisi }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->alamat }}</td>
                        <td>{{ $data->tanggal_pesan }}</td>
                        <td>{{ $data->tanggal_kembali }}</td>
                        <td>{{ "Rp " . number_format($data->dp_bayar , 0, ',', '.')}}</td>
                        <td>{{ "Rp " . number_format($data->getDendaAttribute(), 0, ',', '.') }}</td>
                        <td>{{ $data->biaya_driver }}</td>
                        <td>{{ "Rp " . number_format($data->total_with_denda, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Data laporan belum ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button class='btn btn-primary' wire:click="exportpdf">Export PDF</button>
    </div>
</div>
