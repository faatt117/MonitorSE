<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Interval Screenshot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pengaturan Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Shadow */
            padding: 10px 0;
        }

        .navbar .navbar-brand img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: 500;
            padding: 10px 20px;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
            background-color: #f1f1f1;
        }

        .navbar-nav.ms-auto {
            margin-left: auto;
        }

        /* Container untuk Form */
        .container1 {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Heading */
        h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Layout Form */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Styling Label */
        form label {
            font-weight: 500;
            margin-bottom: 10px;
            color: #555;
        }

        /* Styling Input */
        form input[type="number"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: border-color 0.2s;
        }

        form input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Styling Tombol */
        button[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Styling Pesan Sukses */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        /* Styling Tombol Kembali */
        .back-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .navbar .navbar-brand img {
                height: 30px;
            }

            .container {
                margin: 20px;
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            form input[type="number"] {
                font-size: 14px;
                padding: 10px;
            }

            button[type="submit"] {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/detail{name_device}">
                <img src="{{ asset('image/dclogo.png') }}" alt="Smart Eyes Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/beranda">Beranda</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container1">
        <h2>Pengaturan Screenshot</h2>

        <!-- Menampilkan Pesan Sukses -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Pengaturan Screenshot -->
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div>
                <label for="screenshot_interval">Interval Screenshot (dalam detik):</label>
                <input type="number" name="screenshot_interval" id="screenshot_interval" value="{{ old('screenshot_interval', $screenshot_interval) }}" required min="1">
            </div>

            <div>
                <button type="submit">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
