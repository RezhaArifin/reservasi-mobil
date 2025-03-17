<div class="col-sm-12 col-xl-12">
    <div class="bg-light rounded h-100 p-4">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
        @endif
        <h6 class="mb-4">Data Mobil</h6>
        <div class="row">
            @foreach ($mobil as $data)
                @if ($data->status_mobil === 'ready')
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('storage/mobil/' . $data->foto) }}"style="height:200px; width:px;"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->merk }}</h5>
                            <p class="card-text">{{ $data->jenis }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">No Polisi : {{ $data->nopolisi }}</li>
                            <li class="list-group-item">Kapasitas : {{ $data->kapasitas }}</li>
                            <li class="list-group-item">Harga Mobil : {{ $data->harga }}</li>
                        </ul>
                        <div class="card-body">
                            <button
                                wire:click="create({{ $data->id }}, {{ $data->harga }}, {{ $data->biaya_driver }})"
                                class="btn btn-outline-success card-link">Pilih Mobil</button>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        </div>
        @if ($addPage)
            @include('transaksi.create')
        @endif
    </div>
</div>
