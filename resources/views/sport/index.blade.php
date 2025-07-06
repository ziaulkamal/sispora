@extends('layouts::admin')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.sport.insert') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">{{ ucwords($section) ?? null }}</li>
                        <li class="breadcrumb-item active"> {{ ucwords($selectedSection) ?? null }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive theme-scrollbar">
                            <table class="display" id="keytable">
                                <thead>
                                    <tr>
                                        <th>Nama Cabang Olahraga</th>
                                        <th>Kelas Cabor Tersedia</th>
                                        <th>Status</th>
                                        <th>Aturan</th>
                                        <th>Terakhir Diubah</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sport as $sports)
                                    <tr id="sports-row-{{ $sports['id'] }}">
                                        <td>{{ strtoupper($sports['name']) }}</td>
                                        <td>
                                            @if(isset($sports['sub_sports']) && count($sports['sub_sports']) > 0)
                                                <div style="display: flex; flex-wrap: wrap; max-width: 350px; gap: 0.5rem;">
                                                    @foreach($sports['sub_sports'] as $sub)
                                                        <span class="badge bg-outline-primary">#{{ $sub['name'] }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">Belum ada kelas</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-{{ $sports['status'] === 'active' ? 'success' : 'warning' }}">{{ ucwords($sports['status']) }}</span></td>
                                        <td>
                                            @if($sports['specialCase'] === 'umum')
                                                <a href="javascript:;"
                                                class="badge bg-primary"
                                                onclick="confirmSpecialCase('{{ $sports['id'] }}')">
                                                {{ ucwords($sports['specialCase']) }}
                                                </a>
                                            @else
                                                <span class="badge bg-danger">
                                                    {{ ucwords($sports['specialCase']) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $sports['updated_at'] }}</td>
                                        <td>
                                            <ul class="action d-flex gap-2 flex-wrap flex-md-nowrap">
                                                    <li>
                                                        <a href="{{ route('view.sport.subs', ['id' => $sports['id']]) }}"

                                                        class="btn btn-link p-0 m-0 text-success open-subsport-modal"
                                                        title="Tambah Kelas">
                                                        <i class="icon-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                    <a href="{{ route('view.sport.update', $sports['id']) }}" title="Edit" class="btn btn-link p-0 m-0 text-purple">
                                                        <i class="icon-pencil-alt"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form onsubmit="return deleteSports(event, '{{ route('web.sports.destroy', $sports['id']) }}', '{{ $sports['id'] }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 m-0 text-danger" title="Hapus">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
function deleteSports(event, url, id) {
    event.preventDefault();

    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        buttons: ["Batal", "Ya, hapus!"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#sports-row-' + id).remove();
                    Swal.fire("Berhasil!", "Data berhasil dihapus.", "success");
                },
                error: function (xhr) {
                    let message = xhr.responseJSON?.message || "Terjadi kesalahan saat menghapus data.";
                    Swal.fire("Gagal!", message, "error");
                }
            });
        }
    });

    return false;
}
</script>

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    function confirmSpecialCase(sportsId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Aturan ini diperuntukan untuk kategori Bola, apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, proses',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('web.sports.special-case', ':id') }}";
                url = url.replace(':id', sportsId);

                $.get(url, function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Aturan berhasil dirubah.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }).fail(function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses.', 'error');
                });
            }
        });
    }
</script>

@endsection

@section('headScripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
