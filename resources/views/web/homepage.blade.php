<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUTRA INDAH TRANS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
        }

        .navbar a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            width: 100%;
            bottom: 0;
        }

        /* Additional styling for the page */
        .container {
            margin-top: 5px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .overlay {
            position: relative;
            width: 100%;
            height: 40vh;
            background-image: url('https://www.gardaoto.com/wp-content/uploads/2022/02/Ingin-Buka-Usaha-Rental-Mobil-Ini-Syarat-Kelengkapannya.jpg');
            background-size: cover;
            background-position: center;
        }

        .overlay .overlay-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .overlay .overlay-content h2,
        .overlay .overlay-content p {
            text-align: center;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">Putra Indah Trans</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/6287832716259" target="_blank">
                            <i class="fab fa-whatsapp"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://maps.app.goo.gl/w9qzYu9VJpFeNJTC6" target="_blank">
                            <i class="fas fa-map-marker-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Overlay Section -->
    <div class="overlay">
        <div class="overlay-content">
            <div>
                <h2>Selamat Datang di Rental Mobil PUTRA INDAH TRANS</h2>
                <p>Silahkan Pilih Mobil Yang Ada Ingin Sewa !!!</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            @foreach ($mobils as $mobil)
                @if ($mobil->status_mobil === 'ready')
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('storage/mobil/' . $mobil->foto) }}" class="card-img-top" alt="Mobil"
                                style="height:200px; width:100%;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $mobil->merk }}</h5>
                                <p class="card-text">{{ $mobil->jenis }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">No Polisi : {{ $mobil->nopolisi }}</li>
                                <li class="list-group-item">Kapasitas : {{ $mobil->kapasitas }}</li>
                                <li class="list-group-item">Harga Mobil : Rp
                                    {{ number_format($mobil->harga, 0, ',', '.') }}</li>
                            </ul>
                            <div class="card-body">
                                <button class="btn btn-outline-success pilih-mobil" data-id="{{ $mobil->id }}"
                                    data-harga="{{ $mobil->harga }}" data-driver="{{ $mobil->biaya_driver }}">Pilih
                                    Mobil</button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Form Transaksi -->
        <div class="col-sm-12 col-xl-6 mt-5">
            <div class="bg-light rounded h-100 p-4" id="form-transaksi-container" style="display: none;">
                <h6 class="mb-4">Add Transaksi</h6>
                <form id="form-transaksi" method="POST" action="{{ route('store') }}">
                    @csrf
                    <input type="hidden" id="mobil_id" name="mobil_id">
                    <input type="hidden" id="harga" name="harga">
                    <input type="hidden" id="total" name="total">
                    <input type="hidden" id="dp_bayar" name="dp_bayar">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="ponsel" class="form-label">Nomor Ponsel Pemesan</label>
                        <input type="text" class="form-control" name="ponsel" id="ponsel" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Pemesan</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal Pemesanan</label>
                        <input type="date" class="form-control" name="tanggal_pesan" id="tanggal_pesan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                        <select name="pembayaran" id="pembayaran" class="form-control" required>
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="Bayar DP">Bayar DP</option>
                            <option value="Bayar Langsung">Bayar Langsung</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="biaya_driver" class="form-label">Metode Driver</label>
                        <select id="biaya_driver" name="biaya_driver" class="form-control" required>
                            <option value="Without-Drive">Tanpa Driver</option>
                            <option value="With-Drive">Dengan Driver</option>
                        </select>
                    </div>
                    <button data-toggle="modal" data-target="#summaryModal" type="button"
                        class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Summary -->
    <!-- Modal Summary -->
    <div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryModalLabel">Ringkasan Pemesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Data Pemesan:</h6>
                    <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
                    <p><strong>No Ponsel:</strong> <span id="modal-ponsel"></span></p>
                    <p><strong>Alamat:</strong> <span id="modal-alamat"></span></p>
                    <p><strong>Tanggal Pemesanan:</strong> <span id="modal-tanggal-pesan"></span></p>
                    <p><strong>Tanggal Kembali:</strong> <span id="modal-tanggal-kembali"></span></p>
                    <p><strong>Metode Pembayaran:</strong> <span id="modal-pembayaran"></span></p>
                    <p><strong>Harga Mobil:</strong> Rp <span id="modal-harga"></span></p>
                    <p><strong>Biaya Driver:</strong> Rp <span id="modal-biaya-driver"></span></p>
                    <p><strong>Total:</strong> Rp <span id="modal-total"></span></p>
                    <p><strong>Total DP:</strong> Rp <span id="modal-total-dp"></span></p>
                    <!-- Menambahkan Total DP -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="confirm-save" form="form-transaksi"
                        class="btn btn-primary">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>



    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Putra Indah Trans. All Rights Reserved.</p>
    </footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    <script>
        $(document).ready(function() {
            // Menangani klik pada tombol pilih mobil
            $('.pilih-mobil').click(function() {
                var harga = $(this).data('harga'); // Harga mobil
                var biaya_driver = $(this).data('driver'); // Biaya driver (bisa 0 atau 50000)
                var mobilId = $(this).data('id'); // ID mobil yang dipilih

                // Pastikan data sudah di-set dengan benar
                $('#mobil_id').val(mobilId);
                $('#harga').val(harga);
                $('#biaya_driver').val(biaya_driver); // Pastikan nilai disimpan

                // Tampilkan form transaksi
                $("#form-transaksi-container").slideDown();

                // Geser halaman ke form transaksi
                $('html, body').animate({
                    scrollTop: $("#form-transaksi-container").offset().top
                }, 500); // 500 ms untuk smooth scroll
            });

            // Menangani klik pada tombol simpan (show modal)
            $('button[type="button"]').click(function() {
                // Ambil nilai dari form
                var nama = $('#nama').val();
                var ponsel = $('#ponsel').val();
                var alamat = $('#alamat').val();
                var tanggal_pesan = $('#tanggal_pesan').val();
                var tanggal_kembali = $('#tanggal_kembali').val();
                var pembayaran = $('#pembayaran').val();
                var harga = parseInt($('#harga').val()) || 0;
                var biaya_driver = ($('#biaya_driver').val() === 'With-Drive') ? 50000 : 0;

                // Hitung total
                var total = harga + biaya_driver;

                // Hitung DP (50% jika bayar DP, 0 jika bayar langsung)
                var dp_bayar = (pembayaran === 'Bayar DP') ? total * 0.5 : 0;

                // Tampilkan data di modal ringkasan
                $('#modal-nama').text(nama);
                $('#modal-ponsel').text(ponsel);
                $('#modal-alamat').text(alamat);
                $('#modal-tanggal-pesan').text(tanggal_pesan);
                $('#modal-tanggal-kembali').text(tanggal_kembali);
                $('#modal-pembayaran').text(pembayaran);
                $('#modal-harga').text(harga.toLocaleString());
                $('#modal-biaya-driver').text('Rp ' + biaya_driver.toLocaleString());
                $('#modal-total').text('Rp ' + total.toLocaleString());
                $('#modal-total-dp').text('Rp ' + dp_bayar.toLocaleString());

                // Set hidden input untuk total dan DP
                $('#total').val(total);
                $('#dp_bayar').val(dp_bayar);

                // Tampilkan modal ringkasan
                $('#summaryModal').modal('show');
            });

            // Konfirmasi pembayaran ketika tombol "Konfirmasi" diklik
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#confirm-save').on('click', function(event) {
                event.preventDefault(); // Mencegah form melakukan submit normal

                console.log('Tombol Konfirmasi diklik!');

                var formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    nama: $('#nama').val(),
                    ponsel: $('#ponsel').val(),
                    alamat: $('#alamat').val(),
                    tanggal_pesan: $('#tanggal_pesan').val(),
                    tanggal_kembali: $('#tanggal_kembali').val(),
                    pembayaran: $('#pembayaran').val(),
                    biaya_driver: $('#biaya_driver').val(),
                    mobil_id: $('#mobil_id').val(),
                    harga: $('#harga').val(),
                    total: $('#total').val(),
                    dp_bayar: $('#dp_bayar').val()
                };

                console.log('Mengirim data ke /store:', formData);

                $.ajax({
                    url: '/store',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Response dari server:', response);

                        if (response.snap_token) {
                            console.log('Snap Token diterima:', response.snap_token);

                            // Menjalankan pembayaran dengan Midtrans
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    console.log('Pembayaran Berhasil:', result);
                                    alert('Pembayaran berhasil!');
                                    window.location.href = '/order-success';
                                },
                                onPending: function(result) {
                                    console.log('Pembayaran Pending:', result);
                                    alert('Pembayaran sedang diproses.');
                                },
                                onError: function(result) {
                                    console.error('Error dalam pembayaran:',
                                        result);
                                    alert('Terjadi kesalahan dalam pembayaran.');
                                }
                            });
                        } else {
                            console.error('Gagal memperoleh snap token:', response);
                            alert('Mobil Ini Sudah Terpesan Pada Tanggal Ini');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error dari AJAX:', xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan data transaksi.');
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById('pembayaran').addEventListener('change', function() {
            var pembayaran = this.value;
            var driverSection = document.getElementById('driver-section');

            // Show driver selection only when "Bayar DP" is selected
            if (pembayaran === 'Bayar DP') {
                driverSection.style.display = 'block';
            } else {
                driverSection.style.display = 'none';
            }
        });
    </script>
</body>

</html>
