@extends('layouts::admin')
{{-- @dd($person->kontingen->regencies_id) --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('table.atlet') }}" class="btn btn-sm btn-outline-primary">Lihat Data</a>
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
                        <form id="form-person" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="nomor_induk_kependudukan">Nomor Induk
                                        Kependudukan</label>
                                    <input type="text" class="form-control onlynumber maxchar-16" id="nomor_induk_kependudukan" value="{{ $person['identityNumber'] ?? '' }}"
                                        name="identityNumber" data-url="{{ route('web.people.fetch', ['nik' => '__NIK__']) }}" required readonly>
                                    <div class="invalid-feedback">NIK wajib diisi dan maksimal 16 digit.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control maxchar-40" id="nama_lengkap" name="fullName" value="{{ strtoupper($person['fullName']) ?? '' }}" required>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="gender" required>
                                        <option selected disabled value="">--Pilih--</option>
                                        <option value="male" {{ $person['gender'] === 'male' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="female" {{ $person['gender'] === 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih jenis kelamin.</div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="birthdate"
                                        value="{{ $person['birthdate'] }}" required>
                                    <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="nomor_kartu_keluarga">Nomor Kartu Keluarga</label>
                                    <input type="text" class="form-control onlynumber maxchar-16" id="nomor_kartu_keluarga"
                                        name="familyIdentityNumber" value="{{ $person['familyIdentityNumber'] }}" maxlength="16" required>
                                    <div class="invalid-feedback">Nomor KK wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="nomor_handphone">Nomor Handphone</label>
                                    <input type="text" class="form-control onlynumber maxchar-13" id="nomor_handphone" name="phoneNumber"
                                        maxlength="13" value={{ $person['phoneNumber'] }} required>
                                    <div class="invalid-feedback">Nomor HP wajib diisi.</div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <label class="form-label" for="agama">Agama</label>
                                    <select class="form-select" id="agama" name="religion" required>
                                        <option selected disabled value="">--Pilih--</option>
                                        <option value="1" {{ $person['religion'] == 1 ? 'selected' : ''}}>Islam</option>
                                        <option value="2" {{ $person['religion'] == 2 ? 'selected' : ''}}>Kristen Katolik</option>
                                        <option value="3" {{ $person['religion'] == 3 ? 'selected' : ''}}>Kristen Protestan</option>
                                        <option value="4" {{ $person['religion'] == 4 ? 'selected' : ''}}>Hindu</option>
                                        <option value="5" {{ $person['religion'] == 5 ? 'selected' : ''}}>Buddha</option>
                                        <option value="6" {{ $person['religion'] == 6 ? 'selected' : ''}}>Konghucu</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih agama.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <input type="text" class="form-control maxchar-50" id="alamat" name="streetAddress" value="{{ $person['streetAddress'] }}" required>
                                    <div class="invalid-feedback">Alamat wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="provinsi">Provinsi</label>
                                    <select id="provinsi" name="provinceId" class="form-select" required>
                                        <option selected disabled value="">--Pilih--</option>
                                        <!-- Option dinamis via JS -->
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih provinsi.</div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">

                                <div class="col-md-4">
                                    <label class="form-label" for="kabupaten_kota">Kabupaten/Kota</label>
                                    <select id="kabupaten_kota" name="regencieId" class="form-select" required disabled>
                                        <option selected disabled value="">--Pilih--</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih kabupaten/kota.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="kecamatan">Kecamatan</label>
                                    <select id="kecamatan" name="districtId" class="form-select" required disabled>
                                        <option selected disabled value="">--Pilih--</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih kecamatan.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="desa">Desa</label>
                                    <select id="desa" name="villageId" class="form-select" required disabled>
                                        <option selected disabled value="">--Pilih--</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih desa.</div>
                                </div>
                            </div>
                            @if (isset($section) && $section == 'atlet')
                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <label class="form-label" for="kontingen">Kontingen</label>
                                    <select id="kontingen" name="kontingenId" class="form-select" required>
                                        <option selected disabled value="">--Pilih--</option>
                                        <!-- Option dinamis via JS -->
                                    </select>
                                    <div class="invalid-feedback">Kontingen wajib diisi.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="bb">Berat Badan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control maxchar-4 number" id="bb" name="weight" value="{{ $person['weight'] }}" required>

                                        <span class="input-group-text">Kg</span>
                                        <div class="invalid-feedback">Berat Badan wajib diisi.</div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="tb">Tinggi Badan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control maxchar-4 number" id="tb" name="height" value="{{ $person['height'] }}" required>

                                        <span class="input-group-text">Cm</span>
                                        <div class="invalid-feedback">Tinggi Badan wajib diisi.</div>
                                    </div>
                                </div>
                            </div>
                            @endif

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

                            <button class="btn btn-primary" type="submit">Update Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset
</div>

@endsection

@section('load-mendagri-js')
<script>
$(document).ready(function () {


    function resetSelect($el) {
        $el.html('<option selected disabled value="">--Pilih--</option>').prop('disabled', true);
    }

    function populateSelect(url, $target, selectedValue = null, callback = null) {
        $.get(url, function (data) {
            resetSelect($target);
            $.each(data, function (name, id) {
                const selected = (id == selectedValue) ? 'selected' : '';
                $target.append(`<option value="${id}" ${selected}>${name}</option>`);
            });
            $target.prop('disabled', false);
            if (typeof callback === 'function') callback();
        });
    }

    // Ambil nilai dari server (Blade)
    let province = `{{ $person['provinceId'] ?? '' }}`;
    let regency  = `{{ $person['regencieId'] ?? '' }}`;
    let district = `{{ $person['districtId'] ?? '' }}`;
    let village  = `{{ $person['villageId'] ?? '' }}`;

    let contingent  = `{{ $person->kontingen->regencies_id ?? '' }}`;
    console.log(`Kontingen: ${contingent}`);

    const getProvince = `{{ route('web.mendagri.provinces') }}`;
    const getKontingen = `{{ route('web.mendagri.kontingens') }}`;
    let regenciesRoute = `{{ route('web.mendagri.regencies', ['provinceId' => '__ID__']) }}`;
    regenciesRoute = regenciesRoute.replace('__ID__', province);
    let districtsRoute = `{{ route('web.mendagri.districts', ['regencyId' => '__ID__']) }}`;
    districtsRoute = districtsRoute.replace('__ID__', regency);
    let villagesRoute = `{{ route('web.mendagri.villages', ['districtId' => '__ID__']) }}`;
    villagesRoute = villagesRoute.replace('__ID__', district);
    // console.log(villagesRoute);

    // Load provinsi sampai desa jika ada data
    if (province) {
        populateSelect(getProvince, $('#provinsi'), province, function () {
            populateSelect(regenciesRoute, $('#kabupaten_kota'), regency, function () {
                populateSelect(districtsRoute, $('#kecamatan'), district, function () {
                    populateSelect(villagesRoute, $('#desa'), village);
                });
            });
        });
    } else {
        populateSelect(getProvince, $('#provinsi'));
    }

    // Load kontingen jika ada
    populateSelect(getKontingen, $('#kontingen'), contingent);

    // Event chaining manual
    $('#provinsi').on('change', function () {

        let provId = $(this).val();
        let regenciesRoute = `{{ route('web.mendagri.regencies', ['provinceId' => '__ID__']) }}`;
        regenciesRoute = regenciesRoute.replace('__ID__', provId);
        resetSelect($('#kabupaten_kota'));
        resetSelect($('#kecamatan'));
        resetSelect($('#desa'));
        if (provId) populateSelect(regenciesRoute, $('#kabupaten_kota'));
    });

    $('#kabupaten_kota').on('change', function () {

        let kabId = $(this).val();
        let districtsRoute = `{{ route('web.mendagri.districts', ['regencyId' => '__ID__']) }}`;
        districtsRoute = districtsRoute.replace('__ID__', kabId);
        resetSelect($('#kecamatan'));
        resetSelect($('#desa'));
        if (kabId) populateSelect(districtsRoute, $('#kecamatan'));
    });

    $('#kecamatan').on('change', function () {
        let kecId = $(this).val();
        let villagesRoute = `{{ route('web.mendagri.villages', ['districtId' => '__ID__']) }}`;
        villagesRoute = villagesRoute.replace('__ID__', kecId);
        resetSelect($('#desa'));
        if (kecId) populateSelect(villagesRoute, $('#desa'));
    });
});
</script>
@endsection



@section('footScripts')
<script>
$(document).ready(function () {
    function resetSelect($el) {
        $el.html('<option selected disabled value="">--Pilih--</option>').prop('disabled', true);
    }

    function resetFormFields() {
        $('.needs-validation')[0].reset();
        $('#kabupaten_kota, #kecamatan, #desa').prop('disabled', true).html('<option selected disabled value="">--Pilih--</option>');
    }

    function populateSelect(url, $target, selectedValue = null) {
        $.get(url, function (data) {
            resetSelect($target);
            $.each(data, function (name, id) {
                let selected = (id == selectedValue) ? 'selected' : '';
                $target.append(`<option value="${id}" ${selected}>${name}</option>`);
            });
            $target.prop('disabled', false);
        });
    }

    function triggerAutoFetch() {
        const getProvince = `{{ route('web.mendagri.provinces') }}`;
        let regenciesRoute = `{{ route('web.mendagri.regencies', ['provinceId' => '__ID__']) }}`;
        let districtsRoute = `{{ route('web.mendagri.districts', ['regencyId' => '__ID__']) }}`;
        let villagesRoute = `{{ route('web.mendagri.villages', ['districtId' => '__ID__']) }}`;
        let name = $('#nama_lengkap').val().trim();
        let nik = $('#nomor_induk_kependudukan').val().trim();
        let routeAttribute = `{{ route('web.people.fetch.attribute') }}`;

        if (name && nik.length === 16 && /^\d+$/.test(nik)) {
            $.ajax({
                url: `${routeAttribute}?name=${encodeURIComponent(name)}&nik=${nik}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.name) {
                        regenciesRoute = regenciesRoute.replace('__ID__', data.province);
                        districtsRoute = districtsRoute.replace('__ID__', data.regency);
                        villagesRoute = villagesRoute.replace('__ID__', data.district);
                        $('#jenis_kelamin').val(data.gender);
                        let [mm, dd, yyyy] = data.birthDate.split('/');
                        $('#tanggal_lahir').val(`${yyyy}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`);
                        $('#alamat').val(data.line);

                        populateSelect(getProvince, $('#provinsi'), data.province);
                        populateSelect(regenciesRoute, $('#kabupaten_kota'), data.regency);
                        populateSelect(districtsRoute, $('#kecamatan'), data.district);
                        populateSelect(villagesRoute, $('#desa'), data.village);
                    }
                },
                error: function (xhr) {

                    console.warn('Gagal fetch data atribut:', xhr.responseJSON || xhr.statusText);
                }
            });
        }
    }

    // Event untuk fetch berdasarkan NIK & Nama
    $('#nama_lengkap, #nomor_induk_kependudukan').on('change blur', function () {
        triggerAutoFetch();
    });

    // Placeholder nama berdasarkan NIK
    $('#nomor_induk_kependudukan').on('input', function () {
        let nik = $(this).val();
        let urlTemplate = $(this).data('url');
        if (nik.length === 16 && /^\d+$/.test(nik)) {
            let url = urlTemplate.replace('__NIK__', nik);
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#nama_lengkap').attr('placeholder', data.name || 'Nama tidak ditemukan');
                },
                error: function () {
                    $('#nama_lengkap').attr('placeholder', 'Gagal mengambil data');
                }
            });
        } else {
            $('#nama_lengkap').attr('placeholder', 'Nama akan muncul di sini...');
        }
    });

    // ✅ Inisialisasi Wilayah Berdasarkan Data Blade
    console.log(villagesRoute);
    let province = `{{ $person['province'] ?? '' }}`;
    let regency  = `{{ $person['regency'] ?? '' }}`;
    let district = `{{ $person['district'] ?? '' }}`;
    let village  = `{{ $person['village'] ?? '' }}`;
    const getProvince = `{{ route('web.mendagri.provinces') }}`;
    const getKontingen = `{{ route('web.mendagri.kontingens') }}`;
    let regenciesRoute = `{{ route('web.mendagri.regencies', ['provinceId' => '__ID__']) }}`;
    regenciesRoute = regenciesRoute.replace('__ID__', province);
    let districtsRoute = `{{ route('web.mendagri.districts', ['regencyId' => '__ID__']) }}`;
    districtsRoute = districtsRoute.replace('__ID__', regency);
    let villagesRoute = `{{ route('web.mendagri.villages', ['districtId' => '__ID__']) }}`;
    villagesRoute = villagesRoute.replace('__ID__', village);

    if (province && regency && district && village) {
        populateSelect(getProvince, $('#provinsi'), province);
        populateSelect(regenciesRoute, $('#kabupaten_kota'), regency);
        populateSelect(districtsRoute $('#kecamatan'), district);
        populateSelect(villagesRoute, $('#desa'), village);
    }
});
</script>

<script>
    $(document).ready(function () {
        $('#form-person').on('submit', function (e) {
            e.preventDefault();
            $('#alert-container').html('');
            let routeUpdate = `{{ route("web.people.patch", ['id' => ':id']) }}`;
            routeUpdate = routeUpdate.replace(':id', "{{ $person->id }}");
            const form = $(this)[0];
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            // formData.append('_method', 'PUT'); // Penting untuk edit

            $.ajax({
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: routeUpdate, // ganti sesuai ID
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {

                    $('#alert-container').html(`
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Berhasil!</h4>
                            <p>${response.message ?? 'Data berhasil diperbarui.'}</p>
                            <hr>
                            <p class="mb-0">Perubahan telah disimpan.</p>
                        </div>
                    `);
                    $('html, body').animate({
                            scrollTop: $('#alert-container').offset().top - 100 // sedikit offset dari atas
                        }, 500);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message ?? 'Data berhasil disimpan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // Form tidak direset supaya tetap tampil hasil edit-nya
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = '<ul>';
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorList += `<li>${errors[key][0]}</li>`;
                            }
                        }
                        errorList += '</ul>';

                        $('#alert-container').html(`
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Validasi Gagal!</h4>
                                <p>Terdapat beberapa kesalahan pada data yang Anda kirim:</p>
                                ${errorList}
                                <hr>
                                <p class="mb-0">Silakan perbaiki dan coba lagi.</p>
                            </div>
                        `);
                        $('html, body').animate({
                            scrollTop: $('#alert-container').offset().top - 100 // sedikit offset dari atas
                        }, 500);
                    } else {
                        $('#alert-container').html(`
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                                <p>Server mengalami masalah. Silakan coba beberapa saat lagi.</p>
                                <hr>
                                <p class="mb-0">${xhr.responseJSON?.message ?? 'Unknown error.'}</p>
                            </div>
                        `);
                        $('html, body').animate({
                            scrollTop: $('#alert-container').offset().top - 100 // sedikit offset dari atas
                        }, 500);
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
    });
</script>


@endsection
