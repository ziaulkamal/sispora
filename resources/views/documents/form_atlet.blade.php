@extends('layouts::admin')
{{-- @dd(ini_get('upload_max_filesize'), ini_get('post_max_size')); --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    {{-- <a href="{{ route('form.atlet') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a> --}}
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 box-col-70">
                <div class="default-according style-1 job-accordion">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">

                                <!-- FOTO PROFIL -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Foto Profil</div>
                                        <div class="card-body text-center">
                                            @php
                                                $imageProfileUrl = $document && $document->imageProfile
                                                    ? asset('storage/'.$document->imageProfile)
                                                    : null;
                                                $imageProfileStatus = $document->imageProfile_status ?? null;
                                                $disableImageProfile = $imageProfileUrl && in_array($imageProfileStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formImageProfile" enctype="multipart/form-data">
                                                @csrf
                                                <img id="previewImageProfile" src="{{ $imageProfileUrl ?? 'https://placehold.jp/3d4070/ffffff/150x150.png' }}"
                                                    class="img-fluid mb-2 rounded preview-click" alt="Preview">

                                                @if($imageProfileUrl && $imageProfileStatus)
                                                    <span class="badge m-2
                                                        {{ $imageProfileStatus == 'pending' ? 'bg-warning' : ($imageProfileStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($imageProfileStatus) }}
                                                    </span>
                                                @endif

                                                <input type="file" class="form-control mb-2"
                                                    id="imageProfile" name="file"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    {{ $disableImageProfile ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disableImageProfile ? 'disabled' : '' }}>
                                                    Upload Foto
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- DOKUMEN IDENTITAS -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Dokumen Identitas (KTP/Kartu Pelajar)</div>
                                        <div class="card-body text-center">
                                            @php
                                                $identityProfileUrl = $document && $document->identityProfile
                                                    ? asset('storage/'.$document->identityProfile)
                                                    : null;
                                                $identityProfileStatus = $document->identityProfile_status ?? null;
                                                $disableIdentityProfile = $identityProfileUrl && in_array($identityProfileStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formIdentityProfile" enctype="multipart/form-data">
                                                @csrf
                                                <img id="previewIdentityProfile" src="{{ $identityProfileUrl ?? 'https://placehold.jp/3d4070/ffffff/150x150.png' }}"
                                                    class="img-fluid mb-2 rounded preview-click" alt="Preview">

                                                @if($identityProfileUrl && $identityProfileStatus)
                                                    <span class="badge m-2
                                                        {{ $identityProfileStatus == 'pending' ? 'bg-warning' : ($identityProfileStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($identityProfileStatus) }}
                                                    </span>
                                                @endif

                                                <input type="file" class="form-control mb-2"
                                                    id="identityProfile" name="file"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    {{ $disableIdentityProfile ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disableIdentityProfile ? 'disabled' : '' }}>
                                                    Upload Identitas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- KARTU KELUARGA -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Kartu Keluarga (KK)</div>
                                        <div class="card-body text-center">
                                            @php
                                                $familyProfileUrl = $document && $document->familyProfile
                                                    ? asset('storage/'.$document->familyProfile)
                                                    : null;
                                                $familyProfileStatus = $document->familyProfile_status ?? null;
                                                $disableFamilyProfile = $familyProfileUrl && in_array($familyProfileStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formFamilyProfile" enctype="multipart/form-data">
                                                @csrf
                                                <img id="previewFamilyProfile" src="{{ $familyProfileUrl ?? 'https://placehold.jp/3d4070/ffffff/150x150.png' }}"
                                                    class="img-fluid mb-2 rounded preview-click" alt="Preview">

                                                @if($familyProfileUrl && $familyProfileStatus)
                                                    <span class="badge m-2
                                                        {{ $familyProfileStatus == 'pending' ? 'bg-warning' : ($familyProfileStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($familyProfileStatus) }}
                                                    </span>
                                                @endif

                                                <input type="file" class="form-control mb-2"
                                                    id="familyProfile" name="file"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    {{ $disableFamilyProfile ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disableFamilyProfile ? 'disabled' : '' }}>
                                                    Upload KK
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- SERTIFIKAT PRIBADI -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Sertifikat Pribadi</div>
                                        <div class="card-body text-center">
                                            @php
                                                $personalCertificateUrl = $document && $document->personalCertificate
                                                    ? asset('storage/'.$document->personalCertificate)
                                                    : null;
                                                $personalCertificateStatus = $document->personalCertificate_status ?? null;
                                                $disablePersonalCertificate = $personalCertificateUrl && in_array($personalCertificateStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formPersonalCertificate" enctype="multipart/form-data">
                                                @csrf
                                                <img id="previewPersonalCertificate" src="{{ $personalCertificateUrl ?? 'https://placehold.jp/3d4070/ffffff/150x150.png' }}"
                                                    class="img-fluid mb-2 rounded preview-click" alt="Preview">

                                                @if($personalCertificateUrl && $personalCertificateStatus)
                                                    <span class="badge m-2
                                                        {{ $personalCertificateStatus == 'pending' ? 'bg-warning' : ($personalCertificateStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($personalCertificateStatus) }}
                                                    </span>
                                                @endif

                                                <input type="file" class="form-control mb-2"
                                                    id="personalCertificate" name="file"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    {{ $disablePersonalCertificate ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disablePersonalCertificate ? 'disabled' : '' }}>
                                                    Upload Sertifikat
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- IJAZAH -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Ijazah Terakhir</div>
                                        <div class="card-body text-center">
                                            @php
                                                $lastDiplomaUrl = $document && $document->lastDiploma
                                                    ? asset('storage/'.$document->lastDiploma)
                                                    : null;
                                                $lastDiplomaStatus = $document->lastDiploma_status ?? null;
                                                $disableLastDiploma = $lastDiplomaUrl && in_array($lastDiplomaStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formLastDiploma" enctype="multipart/form-data">
                                                @csrf
                                                <img id="previewLastDiploma" src="{{ $lastDiplomaUrl ?? 'https://placehold.jp/3d4070/ffffff/150x150.png' }}"
                                                    class="img-fluid mb-2 rounded preview-click" alt="Preview">

                                                @if($lastDiplomaUrl && $lastDiplomaStatus)
                                                    <span class="badge m-2
                                                        {{ $lastDiplomaStatus == 'pending' ? 'bg-warning' : ($lastDiplomaStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($lastDiplomaStatus) }}
                                                    </span>
                                                @endif

                                                <input type="file" class="form-control mb-2"
                                                    id="lastDiploma" name="file"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    {{ $disableLastDiploma ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disableLastDiploma ? 'disabled' : '' }}>
                                                    Upload Ijazah
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- PDF -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-header">Dokumen Pendukung (PDF)</div>
                                        <div class="card-body text-center">
                                            @php
                                                $supportPdfUrl = $document && $document->supportPdf
                                                    ? asset('storage/'.$document->supportPdf)
                                                    : null;
                                                $supportPdfStatus = $document->supportPdf_status ?? null;
                                                $disableSupportPdf = $supportPdfUrl && in_array($supportPdfStatus, ['pending', 'approve']);
                                            @endphp

                                            <form id="formSupportPdf" enctype="multipart/form-data">
                                                @csrf
                                                <span class="badge bg-secondary mb-2">Upload PDF</span>

                                                @if($supportPdfUrl && $supportPdfStatus)
                                                    <span class="badge m-2
                                                        {{ $supportPdfStatus == 'pending' ? 'bg-warning' : ($supportPdfStatus == 'approve' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ ucfirst($supportPdfStatus) }}
                                                    </span>
                                                @endif

                                                @if($document && $document->supportPdf)

                                                    <a href="{{ asset('storage/'.$document->supportPdf) }}" class="pdf-preview">
                                                        <span class="badge bg-info mb-2">Lihat PDF</span>
                                                    </a>
                                                @endif
                                                <input type="file" class="form-control mb-2"
                                                    id="supportPdf" name="file"
                                                    accept="application/pdf"
                                                    {{ $disableSupportPdf ? 'disabled' : '' }}>

                                                <button type="submit" class="btn btn-primary w-100"
                                                    {{ $disableSupportPdf ? 'disabled' : '' }}>
                                                    Upload PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footScripts')
<script>
function initFilePreview(formId) {
    const form = document.getElementById(formId);
    const fileInput = form.querySelector('input[type="file"]');
    const preview = form.querySelector('img');

    if (fileInput && preview) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files && fileInput.files[0]) {
                preview.src = URL.createObjectURL(fileInput.files[0]);
            }
        });
    }
}

function uploadDocument(formId, field, peopleId) {
    const form = $('#' + formId);

    form.on('submit', function (e) {
        e.preventDefault();

        const fileInput = form.find('input[type="file"]')[0];
        if (fileInput.files.length === 0) {
            Swal.fire('Oops!', 'Silakan pilih file terlebih dahulu.', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('field', field);

        let routeUpload = `{{ route('web.documents.upload', ['peopleId' => ':peopleId']) }}`;
        routeUpload = routeUpload.replace(':peopleId', peopleId);

        Swal.fire({
            title: 'Mengupload...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: routeUpload,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message || 'File berhasil diupload.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                })
                .then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                console.log(xhr);

                let errorMsg = 'Terjadi kesalahan saat upload.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors.file || [];
                    errorMsg = errors.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire('Gagal!', errorMsg, 'error');
            }
        });
    });
}

// Init preview
initFilePreview('formImageProfile');
initFilePreview('formIdentityProfile');
initFilePreview('formFamilyProfile');
initFilePreview('formPersonalCertificate');
initFilePreview('formLastDiploma');

// Init upload
uploadDocument('formImageProfile', 'imageProfile', '{{ $peopleId }}');
uploadDocument('formIdentityProfile', 'identityProfile', '{{ $peopleId }}');
uploadDocument('formFamilyProfile', 'familyProfile', '{{ $peopleId }}');
uploadDocument('formPersonalCertificate', 'personalCertificate', '{{ $peopleId }}');
uploadDocument('formLastDiploma', 'lastDiploma', '{{ $peopleId }}');
uploadDocument('formSupportPdf', 'supportPdf', '{{ $peopleId }}');

document.querySelectorAll('img.preview-click, a.pdf-preview').forEach(el => {
    el.addEventListener('click', function(e) {
        e.preventDefault();

        if (el.tagName.toLowerCase() === 'img') {
            Swal.fire({
                imageUrl: el.getAttribute('src'),
                imageAlt: 'Preview Gambar',
                showCloseButton: true,
                showConfirmButton: false,
                width: '90%',
                background: '#fff'
            });
        } else if (el.tagName.toLowerCase() === 'a') {
            Swal.fire({
                html: `<iframe src="${el.getAttribute('href')}" style="width:100%; height:80vh;" frameborder="0"></iframe>`,
                width: '90%',
                showCloseButton: true,
                showConfirmButton: false
            });
        }
    });
});
</script>
@endsection