@extends('layouts::admin')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.venue.insert') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">{{ ucwords($section) ?? null }}</li>
                        <li class="breadcrumb-item active"> {{ ucwords($selectedSection) ?? null }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-4">
            <!-- Map Section -->
            <div class="col-xl-7 col-lg-7 mb-4">
                <div id="map" class="mb-2"></div>
                <div id="mapCoords" class="text-muted small text-end mb-3">
                    Koordinat: <span id="lat">-</span>, <span id="lng">-</span>
                </div>
            </div>

            <!-- Table Section -->
            <div class="col-xl-5 col-lg-5 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Daftar Venue</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th style="width:70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="venueTableBody"></tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <nav>
                            <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('headScripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 500px; width: 100%; border-radius: 10px; }
    .table-hover tbody tr:hover { cursor: pointer; background-color: #f2f2f2; }
    #mapCoords {
        font-family: monospace;
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 6px;
        display: inline-block;
        float: right;
    }
</style>
@endsection

@section('footScripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const venues = @json($venues);
    const map = L.map('map').setView([4.72672, 95.57006], 10);

    L.tileLayer('https://tile.openstreetmap.de/{z}/{x}/{y}.png', {
        attribution: '<img src="https://flagcdn.com/16x12/id.png" alt="ID Flag"> &copy; OpenStreetMap contributors'
    }).addTo(map);

    map.on('mousemove', function (e) {
        document.getElementById('lat').textContent = e.latlng.lat.toFixed(5);
        document.getElementById('lng').textContent = e.latlng.lng.toFixed(5);
    });

    const markers = {};
    venues.forEach(v => {
        const m = L.marker([v.latitude, v.longitude])
            .addTo(map)
            .bindPopup(`<b>${v.name}</b><br>${v.location}`);
        markers[v.id] = m;
    });

    const rowsPerPage = 5;
    let currentPage = 1;

    function renderTable(page = 1) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const tableBody = document.getElementById("venueTableBody");
        tableBody.innerHTML = "";

        venues.slice(start, end).forEach((v, idx) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${start + idx + 1}</td>
                <td style="cursor:pointer" onclick="focusMarker('${v.id}')">${v.name}</td>
                <td>${v.location}</td>
                <td>
                    <ul class="action d-flex gap-2 flex-wrap flex-md-nowrap">
                        <li>
                        <a href="{{ url('venue/edit') }}/${v.id}" title="Edit" class="btn btn-link p-0 m-0 text-primary">
                            <i class="icon-eye"></i>
                        </a>
                    </li>
                    <li>
                        <button type="button" title="Hapus" onclick="deleteVenue('${v.id}')" class="btn btn-link p-0 m-0 text-danger">
                            <i class="icon-trash"></i>
                        </button>
                    </li>
                    </ul>
                </td>
            `;
            tableBody.appendChild(row);
        });

        renderPagination();
    }

    function focusMarker(id) {
        if(markers[id]){
            map.setView(markers[id].getLatLng(), 14);
            markers[id].openPopup();
        }
    }

    function renderPagination() {
        const totalPages = Math.ceil(venues.length / rowsPerPage);
        const pagination = document.getElementById("pagination");
        pagination.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === currentPage ? "active" : ""}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.onclick = (e) => {
                e.preventDefault();
                currentPage = i;
                renderTable(currentPage);
            };
            pagination.appendChild(li);
        }
    }

    function deleteVenue(id) {
        let routeDeleteVenue = "{{  route('web.venues.destroy', ['id' => ':id']) }}";
        routeDeleteVenue = routeDeleteVenue.replace(':id', id);
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data venue akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: routeDeleteVenue,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Data venue berhasil dihapus.', 'success').then(() => location.reload());
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal!', message, 'error');
                    }
                });
            }
        });
    }

    renderTable(currentPage);
</script>
@endsection


