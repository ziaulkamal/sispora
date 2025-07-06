@extends('layouts::admin')
{{-- @dd($person) --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.schedule.series.index') }}" class="btn btn-sm btn-outline-primary">Lihat Data</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a>
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
                                    <label for="tanggal" class="form-label">Group</label>
                                    <select class="form-select" id="group" name="group" required>
                                        <option selected disabled>Pilih Group...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                    <div class="invalid-feedback">Tanggal wajib diisi.</div>
                                </div>
                            </div>


                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
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
$(function(){
    let sportsRoute = "{{ route('web.sports.index') }}";
    let kontingenRoute = "{{ route('web.kontingen.register') }}";
    let filteredData = [];
    let kontingenData = [];
    let selectedKontingen = [];

    $.ajax({
        url: sportsRoute,
        method: 'GET',
        success: function(data) {
            // filter hanya specialCase khusus
            filteredData = data.filter(function(sport) {
                return sport.specialCase === 'khusus';
            });

            console.log(filteredData);

            let cabangSelect = $('#cabang_olahraga');
            cabangSelect.empty().append('<option value="">Pilih cabang...</option>');
            filteredData.forEach(function(sport) {
                cabangSelect.append(`<option value="${sport.id}">${sport.name}</option>`);
            });
        }
    });

    // Change cabang olahraga
    $('#cabang_olahraga').on('change', function() {
        let selectedId = $(this).val();
        let kelasSelect = $('#kelas');
        kelasSelect.empty().append('<option value="">Pilih kelas...</option>');

        if (!selectedId) {
            kelasSelect.prop('disabled', true);
            return;
        }

        // Cari sport di filteredData
        let selectedSport = filteredData.find(s => s.id == selectedId);
        if (selectedSport && selectedSport.sub_sports && selectedSport.sub_sports.length) {
            selectedSport.sub_sports.forEach(function(sub) {
                kelasSelect.append(`<option value="${sub.id}">${sub.name}</option>`);
            });
            kelasSelect.prop('disabled', false);
        } else {
            kelasSelect.prop('disabled', true);
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

        // === Pilih kontingen
    $('#addKontingenBtn').on('click', function() {
        let kontingenId = $('#kontingen').val();

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

})
</script>



<script src="{{ asset('assets') }}/js/custom-addons.js"></script>

@endsection
