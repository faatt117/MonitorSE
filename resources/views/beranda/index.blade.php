<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Eyes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS untuk tampilan box perangkat */
        .device-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .device-box:hover {
            transform: scale(1.02);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .device-status {
            font-size: 0.9em;
            font-weight: bold;
        }

        .status-on {
            color: green;
        }

        .status-off {
            color: red;
        }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('image/dclogo.png') }}" alt="Smart Eyes Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/settings">Pengaturan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container utama untuk perangkat -->
    <div class="container mt-4">
        <h2 class="mb-4">Perangkat yang Terpantau</h2>

        <div class="row">
            @foreach($user as $device)
            <div class="col-md-4">
                <div class="device-box" onclick="window.location.href='/detail/{{ $device->name_device }}'">
                    <h5>{{ $device->name_device ?? 'Unknown Device' }}</h5> <!-- Mengakses nama perangkat -->
                    <p class="device-status {{ $device->status_device ? 'status-on' : 'status-off' }}">
                        {{ $device->status_device ? 'ON' : 'OFF' }} <!-- Mengakses status perangkat -->
                    </p>
                </div>
            </div>
            @endforeach


        </div>
    </div>

    <!-- Modal untuk menampilkan detail perangkat -->
    <div class="modal fade" id="deviceDetailModal" tabindex="-1" aria-labelledby="deviceDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceDetailModalLabel">Detail Perangkat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deviceDetailContent">
                    <!-- Konten detail perangkat akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk memuat detail perangkat
        function showDeviceDetails(deviceId) {
            fetch(`/device/details/${deviceId}`)
                .then(response => response.json())
                .then(data => {
                    // Isi modal dengan detail perangkat
                    let content = `<p><strong>Nama Perangkat:</strong> ${data.name}</p>`;
                    content += `<p><strong>Status:</strong> ${data.status ? 'ON' : 'OFF'}</p>`;
                    document.getElementById('deviceDetailContent').innerHTML = content;

                    // Tampilkan modal
                    var deviceDetailModal = new bootstrap.Modal(document.getElementById('deviceDetailModal'));
                    deviceDetailModal.show();
                })
                .catch(error => console.error('Error:', error));
        }

    </script>
</body>
</html>
