@extends('layouts::admin')
{{-- @dd($person) --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.sport') }}" class="btn btn-sm btn-outline-primary">Lihat Data</a>
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
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div id="alert-container"></div>
                    </div>

                    <div class="card-body">
                        <form id="form-sport" class="needs-validation" novalidate>
                            @csrf

                             <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="nama_cabor">Nama Cabang Olahraga</label>
                                    <input type="text" class="form-control maxchar-40" id="nama_cabor" name="name"
                                        value="{{ strtoupper($sport->name) ?? '' }}" required>
                                    <div class="invalid-feedback">Nama Cabor wajib diisi.</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" {{ (isset($sport) && $sport->status === 'active') ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ (isset($sport) && $sport->status === 'inactive') ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih Status.</div>
                                </div>
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
let routeUpdate = `{{ route("web.sports.patch", ['id' => ':id']) }}`;
routeUpdate = routeUpdate.replace(':id', "{{ $sport->id }}");
$('#form-sport').on('submit', function (e) {
    e.preventDefault();
    $('#alert-container').html('');

    const form = $(this)[0];
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const formData = new FormData(form);

    $.ajax({
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: routeUpdate,
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#alert-container').html(`
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Berhasil!</h4>
                    <p>${response.message ?? 'Data berhasil disimpan.'}</p>
                    <hr>
                    <p class="mb-0">Anda akan diarahkan kembali dalam beberapa detik.</p>
                </div>
            `);

            setTimeout(function () {
                window.location.href = '{{ route("view.sport") }}';
            }, 2000);

        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorList = '<ul>';
                for (const key in errors) {
                    errorList += `<li>${errors[key][0]}</li>`;
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
            } else {
                $('#alert-container').html(`
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                        <p>Server mengalami masalah. Silakan coba beberapa saat lagi.</p>
                        <hr>
                        <p class="mb-0">${xhr.responseJSON?.message ?? 'Unknown error.'}</p>
                    </div>
                `);
            }
        }
    });
});

</script>

@endsection
