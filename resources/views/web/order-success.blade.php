<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Berhasil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin-top: 10px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #1E90FF;
            color: white;
            font-size: 24px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .success-message {
            text-align: center;
            font-size: 22px;
            color: #28a745;
            margin-bottom: 30px;
        }

        .list-group-item {
            font-size: 18px;
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
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">Putra Indah Trans</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <!-- WhatsApp Link -->
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

    <!-- Main Content -->
    <div class="container">
        @if ($transaksi)
            <div class="card">
                <div class="card-header">
                    <strong>Terima Kasih! Reservasi Anda Berhasil</strong>
                </div>
                <div class="card-body">
                    <p class="success-message">Reservasi Anda telah berhasil diproses. Berikut adalah detail transaksi
                        Anda:</p>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nama Pemesan: {{ $transaksi->nama }}</strong></li>
                        <li class="list-group-item"><strong>Nomor Booking: {{ $transaksi->kode_booking }}</strong></li>
                        <li class="list-group-item"><strong>Tanggal Pemesanan: {{ $transaksi->tanggal_pesan }}</strong>
                        </li>
                        <li class="list-group-item"><strong>Tanggal Kembali: {{ $transaksi->tanggal_kembali }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                Data transaksi tidak ditemukan.
            </div>
        @endif

    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Putra Indah Trans. All Rights Reserved.</p>
    </footer>

</body>

</html>
