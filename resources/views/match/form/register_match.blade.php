@extends('layouts::admin')
{{-- @dd($person) --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.schedule.index') }}" class="btn btn-sm btn-outline-primary">Lihat Data</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">{{ ucwords($section) ?? null }}</li>
                        <li class="breadcrumb-item active"> {{ ucwords($selectedSection) ?? null }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @isset($form)

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="alert-container"></div>
                    </div>

                    <div class="card-body">
                        <form id="sportForm" class="needs-validation" novalidate>
                            @csrf

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="cabang_olahraga" class="form-label">Cabang Olahraga Utama</label>
                                    <select class="form-select" id="cabang_olahraga" name="mainSport" required>
                                        <option value="">Pilih cabang olahraga...</option>
                                    </select>
                                    <div class="invalid-feedback">Cabang olahraga wajib dipilih.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-select" id="kelas" name="sportsSubId" required disabled>
                                        <option value="">Pilih kelas...</option>
                                    </select>
                                    <div class="invalid-feedback">Kelas wajib dipilih.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="date" required>
                                    <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control" id="waktu_mulai" name="start_time" required>
                                    <div class="invalid-feedback">Waktu mulai wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="waktu_selesai" name="end_time" required>
                                    <div class="invalid-feedback">Waktu selesai wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="venue" class="form-label">Venue</label>
                                    <select class="form-select" id="venue" name="venuesId" required>
                                        <option value="">Pilih venue...</option>
                                        <!-- opsi dinamis dari database -->
                                    </select>
                                    <div class="invalid-feedback">Venue wajib dipilih.</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="match_type" class="form-label">Jenis Pertandingan</label>
                                    <select class="form-select" id="match_type" name="match_type" required>
                                        <option value="independent">Independent</option>
                                        <option value="headtohead">Head to Head</option>
                                        <option value="mass">Mass</option>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label for="kontingen" class="form-label">Pilih Kontingen</label>
                                    <div class="input-group">
                                        <select class="form-select" id="kontingen">
                                            <option value="">Pilih kontingen...</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-primary" id="addKontingenBtn">Tambah</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 mt-3">
                                <h6>Kontingen Terpilih:</h6>
                                <ul id="selectedKontingenList" class="list-group list-group-flush"></ul>
                            </div>


                            <div class="mb-3 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="invalidCheck" required>
                                    <label class="form-check-label" for="invalidCheck">
                                        Saya menyetujui bahwa data yang saya isi adalah benar
                                    </label>
                                    <div class="invalid-feedback">
                                        Anda harus menyetujui sebelum mengirim.
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset
</div>

@endsection

@section('footScripts')
<script>
$(function() {
    let sportsData = [];
    let venuesData = [];
    let kontingenData = [];
    let selectedKontingen = [];
    let matchType = 'independent';
    let sportsRoute = "{{ route('web.sports.index') }}";
    let venuesRoute = "{{ route('web.venues.index') }}";
    let kontingenRoute = "{{ route('web.kontingen.register') }}";
    let schedulesSaveRoute = "{{ route('web.schedules.store') }}";
    // === Ambil data cabang olahraga
    $.ajax({
        url: sportsRoute,
        method: 'GET',
        success: function(data) {
            sportsData = data;
            let cabangSelect = $('#cabang_olahraga');
            data.forEach(function(sport) {
                cabangSelect.append(`<option value="${sport.id}">${sport.name}</option>`);
            });
        }
    });

    // === Ambil data venues
    $.ajax({
        url: venuesRoute,
        method: 'GET',
        success: function(data) {
            venuesData = data;
            let venueSelect = $('#venue');
            data.forEach(function(venue) {
                venueSelect.append(`<option value="${venue.id}">${venue.name}</option>`);
            });
        }
    });

    // === Ambil data kontingen
    $.ajax({
        url: kontingenRoute,
        method: 'GET',
        success: function(data) {
            kontingenData = data;
            let kontingenSelect = $('#kontingen');
            data.forEach(function(k) {
                let name = k.regency_name ?? 'Tanpa Nama';
                kontingenSelect.append(`<option value="${k.id}">${name}</option>`);
            });
        }
    });

    // === Change cabang olahraga
    $('#cabang_olahraga').on('change', function() {
        let selectedId = $(this).val();
        let kelasSelect = $('#kelas');
        kelasSelect.empty().append('<option value="">Pilih kelas...</option>');

        if (!selectedId) {
            kelasSelect.prop('disabled', true);
            return;
        }

        let selectedSport = sportsData.find(s => s.id == selectedId);
        if (selectedSport && selectedSport.sub_sports.length) {
            selectedSport.sub_sports.forEach(function(sub) {
                kelasSelect.append(`<option value="${sub.id}">${sub.name}</option>`);
            });
            kelasSelect.prop('disabled', false);
        } else {
            kelasSelect.prop('disabled', true);
        }
    });

    // === Ganti match type
    $('#match_type').on('change', function() {
        matchType = $(this).val();
        resetSelectedKontingen();
    });

    // === Pilih kontingen
    $('#addKontingenBtn').on('click', function() {
        let kontingenId = $('#kontingen').val();
        if (!kontingenId) {
            Swal.fire('Perhatian', 'Pilih kontingen terlebih dahulu.', 'warning');
            return;
        }

        if (selectedKontingen.includes(kontingenId)) {
            Swal.fire('Perhatian', 'Kontingen ini sudah ditambahkan.', 'info');
            return;
        }

        // Aturan main
        if (matchType === 'independent' && selectedKontingen.length >= 1) {
            Swal.fire('Tidak Diizinkan', 'Untuk pertandingan independent hanya boleh 1 kontingen.', 'error');
            return;
        }
        if (matchType === 'headtohead' && selectedKontingen.length >= 2) {
            Swal.fire('Tidak Diizinkan', 'Untuk pertandingan head to head hanya boleh 2 kontingen.', 'error');
            return;
        }

        // Tambahkan ke list
        selectedKontingen.push(kontingenId);
        let kontingenObj = kontingenData.find(k => k.id == kontingenId);
        let name = kontingenObj ? kontingenObj.regency_name : 'Tanpa Nama';
        $('#selectedKontingenList').append(`<li class="list-group-item d-flex justify-content-between align-items-center">
            ${name}
            <button class="btn btn-sm btn-danger remove-kontingen" data-id="${kontingenId}">Hapus</button>
        </li>`);

        // Disable option
        $(`#kontingen option[value="${kontingenId}"]`).prop('disabled', true);
    });

    // === Hapus kontingen dari list
    $('#selectedKontingenList').on('click', '.remove-kontingen', function() {
        let id = $(this).data('id');
        selectedKontingen = selectedKontingen.filter(k => k !== id);
        $(this).closest('li').remove();
        // Enable kembali option
        $(`#kontingen option[value="${id}"]`).prop('disabled', false);
    });

    // === Submit
    $('#sportForm').on('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.classList.add('was-validated');
            return;
        }

        // Validasi kontingen
        if (matchType === 'headtohead' && selectedKontingen.length != 2) {
            Swal.fire('Gagal', 'Untuk head to head, wajib memilih tepat 2 kontingen.', 'error');
            return;
        }
        if (matchType === 'independent' && selectedKontingen.length != 1) {
            Swal.fire('Gagal', 'Untuk independent, wajib memilih tepat 1 kontingen.', 'error');
            return;
        }
        if (matchType === 'mass' && selectedKontingen.length < 2) {
            Swal.fire('Gagal', 'Untuk mass, wajib memilih minimal 2 kontingen.', 'error');
            return;
        }

        let payload = {
            mainSport: $('#cabang_olahraga').val(),
            date: $('#tanggal').val(),
            start_time: $('#waktu_mulai').val()+":00",
            end_time: $('#waktu_selesai').val()+":00",
            sportsSubId: $('#kelas').val(),
            venuesId: $('#venue').val(),
            status: "active",
            user_id: null,
            match_type: matchType,
            kontingens: selectedKontingen
        };

        $.ajax({
            url: schedulesSaveRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan!'
                });

                resetSelectedKontingen();
                $('#sportForm')[0].reset();
                $('#sportForm').removeClass('was-validated');
                $('#kelas').prop('disabled', true);
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let message = Object.keys(errors).map(k => `${k}: ${errors[k].join(', ')}`).join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        html: message
                    });
                } else if(xhr.status === 423) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Kondisi untuk pertandingan Bola harus ada 2 kontingen yang dipertandingkan dan harus Head To Head.'
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menyimpan data.'
                    });
                }
            }
        });
    });

    function resetSelectedKontingen() {
        selectedKontingen = [];
        $('#selectedKontingenList').empty();
        $('#kontingen option').prop('disabled', false);
    }
});
</script>



<script src="{{ asset('assets') }}/js/custom-addons.js"></script>

@endsection
