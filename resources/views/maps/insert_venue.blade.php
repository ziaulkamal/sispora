@extends('layouts::admin')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">Tambah Data Peta</h3>
                    <a href="{{ route('view.venue.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-4">
            <!-- Map Section -->
            <div class="col-xl-8 col-lg-8 mb-4">
                <div id="map"></div>
            </div>

            <!-- Form Section -->
            <div class="col-xl-4 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Form Input Lokasi</h5>
                    </div>
                    <form id="venueForm">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Venue</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi (Kota / Desa)</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control" required readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control" required readonly>
                                </div>
                            </div>

                            <div class="mb-3" style="display: none">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('headScripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        #map { height: 500px; width: 100%; border-radius: 10px; }
    </style>
@endsection

@section('footScripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const map = L.map('map').setView([5.55, 95.32], 9); // Aceh sebagai default
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '<img src="https://flagcdn.com/16x12/id.png" alt="ID Flag"> &copy; OpenStreetMap contributors',
    }).addTo(map);

    let marker;

    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        const lat = latlng.lat.toFixed(7);
        const lng = latlng.lng.toFixed(7);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng).addTo(map);
        }

        map.setView(latlng, 12); // Zoom ke lokasi
    })
    .addTo(map);
    // Saat klik map, tempatkan marker dan isi form input lat/lon
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(7);
        const lng = e.latlng.lng.toFixed(7);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });
</script>

<script>
    $('#venueForm').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            name: $('input[name="name"]').val(),
            location: $('input[name="location"]').val(),
            latitude: $('input[name="latitude"]').val(),
            longitude: $('input[name="longitude"]').val(),
            status: $('select[name="status"]').val(),
        };

        $.ajax({
            url: "{{ route('web.venues.store') }}",
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                location.reload(); // Refresh halaman
            });
                // alert('Venue berhasil disimpan!');/
                $('#venueForm')[0].reset();
                $('#latitude').val('');
                $('#longitude').val('');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let messages = 'Validasi gagal:\n';
                    $.each(errors, function(key, value) {
                        messages += `- ${value.join(', ')}\n`;
                    });
                    alert(messages);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal !',
                        text: 'Server mengalami masalah. Silakan coba beberapa saat lagi.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    });
</script>

@endsection
