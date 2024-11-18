<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perangkat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .device-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .screenshots-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .screenshot-container {
            position: relative;
            width: 150px;
            height: 150px;
        }

        .screenshots-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .screenshots-gallery img:hover {
            transform: scale(1.05);
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            border: none;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 14px;
            cursor: pointer;
        }

        .screenshot-container p {
            text-align: center;
            font-size: 0.9rem;
        }

    </style>
</head>
<body>
    <!-- Menampilkan pesan kesalahan atau sukses -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/beranda">
                <img src="{{ asset('image/dclogo.png') }}" alt="Smart Eyes Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/settings">Pengaturan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/beranda">Kembali ke Beranda</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        @if (session('message'))
        <div class="alert {{ session('status') == 200 ? 'alert-success' : 'alert-danger' }}">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <!-- Container untuk Detail Perangkat -->
    <div class="container mt-5">
        <div class="device-header">
            <h2>Detail Perangkat: {{ $device->name_device }}</h2>
            <span class="badge {{ $device->status_device ? 'bg-success' : 'bg-danger' }}">
                {{ $device->status_device ? 'Online' : 'Offline' }}
            </span>
            <form action="{{ url('/delete-screenshot-bydevice/' . $device->name_device) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus semua screenshot device ini?');">Hapus Semua</button>
            </form>
        </div>

        <!-- Galeri Screenshots -->
        <h4>Screenshots</h4>
        @if(count($screenshots) > 0)
        <div class="screenshots-gallery">
            @foreach($screenshots as $screenshot)
            <div class="screenshot-container">
                <!-- Gambar dengan klik untuk membuka modal -->
                <img src="{{ asset('storage/' . $screenshot->image_ss) }}" alt="Screenshot" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#screenshotModal" data-src="{{ asset('storage/' . $screenshot->image_ss) }}">
                <p class="text-muted">{{ $screenshot->created_at->format('d M Y, H:i') }}</p>

                <!-- Tombol Hapus -->
                <form action="{{ url('/delete-screenshot/' . $screenshot->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus screenshot ini?');">&times;</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted">Tidak ada screenshot yang tersedia untuk perangkat ini.</p>
        @endif
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="screenshotModal" tabindex="-1" aria-labelledby="screenshotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="screenshotModalLabel">Screenshot Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" alt="Screenshot" id="modalImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript untuk mengupdate gambar di modal
        var screenshotModal = document.getElementById('screenshotModal');
        screenshotModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var imageSrc = button.getAttribute('data-src'); // Mendapatkan src gambar
            var modalImage = screenshotModal.querySelector('#modalImage');
            modalImage.src = imageSrc; // Menentukan src gambar di modal
        });

    </script>
</body>
</html>
