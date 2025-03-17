<div class="col-sm-12 col-xl-12">
    <div class="bg-light rounded h-100 p-4">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
        @endif
        <h6 class="mb-4">Data Mobil</h6>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Polisi</th>
                    <th scope="col">Merk</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Kapasitas</th>
                    <th scope="col">Status</th>
                    <th>P.mobil</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>
                        Proses
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mobil as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->nopolisi }}</td>
                        <td>{{ $data->merk }}</td>
                        <td>{{ $data->jenis }}</td>
                        <td>{{ $data->kapasitas }}</td>
                        <td>{{ $data->status_mobil }}</td>
                        <td>
                            @if ($data->status_mobil == 'ready')
                                <button class="btn btn-sm btn-success"
                                    wire:click="Booking({{ $data->id }})">BOOKING</button>
                            @endif
                            @if ($data->status_mobil == 'booking')
                                <button class="btn btn-sm btn-success"
                                    wire:click="Ready({{ $data->id }})">READY</button>
                            @endif
                            @if ($data->status_mobil == 'ready')
                                <button class="btn btn-sm btn-success"
                                    wire:click="Maintenance({{ $data->id }})">MAINTENANCE</button>
                            @endif
                            @if ($data->status_mobil == 'maintenance')
                                <button class="btn btn-sm btn-success"
                                    wire:click="Ready({{ $data->id }})">READY</button>
                            @endif
                        </td>
                        <td>@rupiah($data->harga)</td>
                        <td>
                            <img src="{{ asset('/storage/mobil/' . $data->foto) }}" style="width: 150px;"
                                alt="{{ $data->merk }}">
                        </td>
                        <td>
                            <button class="btn btn-info" wire:click="edit({{ $data->id }})">Edit</button>
                            <button class="btn btn-danger" wire:click="destroy({{ $data->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Data mobil belum ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button wire:click="create" class="btn btn-primary">Tambah</button>
        @if ($addPage)
            @include('mobil.create')
        @endif
        @if ($editPage)
            @include('mobil.edit')
        @endif
    </div>
</div>
