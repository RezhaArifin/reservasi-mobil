<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <h1>Laporan Transaksi</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No.Booking</th>
                <th scope="col">No Polisi</th>
                <th scope="col">Nama Pemesan</th>
                <th scope="col">Alamat</th>
                <th scope="col">Tanggal Pesan</th>
                <th scope="col">Tanggal Kembali</th>
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
                    <td>{{ number_format($data->total_with_denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Data laporan belum ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
