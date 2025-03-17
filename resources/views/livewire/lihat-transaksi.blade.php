<div class="col-sm-12 col-xl-12">
    <div class="bg-light rounded h-100 p-4">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <h6 class="mb-4">Data Transaksi</h6>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Pemesanan</th>
                    <th scope="col">No Polisi</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tgl.Pesan</th>
                    <th scope="col">Tgl.Kembali</th>
                    <th scope="col">Driver</th>
                    <th scope="col">B.DP</th>
                    <th scope="col">T.hari</th>
                    <th scope="col">Denda</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th>Proses</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->kode_booking }}</td>
                        <td>{{ $data->mobil->nopolisi }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->tanggal_pesan }}</td>
                        <td>{{ $data->tanggal_kembali }}</td>
                        <td>{{ $data->biaya_driver }}</td>
                        <td>{{ "Rp " . number_format($data->dp_bayar , 0, ',', '.')}}</td>
                        <!-- Menampilkan Hari Terlambat -->
                        <td>{{ $data->hari_terlambat }}</td> <!-- Menampilkan hari terlambat -->
                        <td>{{ "Rp " . number_format($data->getDendaAttribute(), 0, ',', '.') }}</td> <!-- Menampilkan denda, jika tidak ada tampilkan 0 -->
                        <td>Rp {{ number_format($data->total_with_denda, 0, ',', '.') }}</td>
                        <td>{{ $data->status }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group dropend">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                    
                                </a>
                                <ul class="dropdown-menu p-2">
                                    @if ($data->status == 'WAIT')
                                        <li class="mb-2">
                                            <button class="btn btn-sm btn-success" wire:click="proses({{ $data->id }})">PROSES</button>
                                        </li>
                                    @endif
                                    @if ($data->status == 'PROSES')
                                        <li class="mb-2">
                                            <button class="btn btn-sm btn-success" wire:click="selesai({{ $data->id }})">SELESAI</button>
                                        </li>
                                    @endif
                                    <li class="mb-2">
                                        <button class="btn btn-sm btn-danger" wire:click="destroy({{ $data->id }})">DESTROY</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Data pesanan belum ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
