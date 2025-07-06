@extends('layouts::admin')
{{-- @dd($people) --}}
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('form.atlet') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive theme-scrollbar">
                            <table class="display" id="keytable">
                                <thead>
                                    <tr>
                                        <th>Nama Atlet</th>
                                        <th>Kelamin</th>
                                        <th>Usia</th>
                                        <th>Nomor Kependudukan</th>
                                        <th>Cabang Olahraga</th>
                                        <th>Terakhir Diubah</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    @foreach ($people as $person)
                                    {{-- @dd($person['sports']) --}}
                                        <tr id="person-row-{{ $person['id'] }}">
                                            <td>{{ $person['fullName'] }}</td>
                                            <td>{{ $person['gender'] }}</td>
                                            <td>{{ $person['age'] }}</td>
                                            <td>{{ $person['identityNumber'] }}</td>
                                            <td style="display: flex; flex-wrap: wrap; max-width: 250px; gap: 0.5rem;">
                                                @if (empty($person['sports']))
                                                    <a href="{{ route('view.atlet.detail', $person['id']) }}">
                                                        <span class="badge pill badge-danger" style="cursor: pointer;">
                                                            Atur Cabor
                                                        </span>
                                                    </a>
                                                @else
                                                    @foreach ($person['sports'] as $sport)
                                                        {{-- @dd($sport['sportsSubId']['name']) --}}
                                                        <a href="{{ route('view.atlet.detail', $person['id']) }}">
                                                            <span class="badge badge-primary">#{{ $person['athletes'][0]['sportsSub']['sport']['name'] }} - {{  $sport }}</span>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $person['updated_at'] }}</td>
                                            <td>
                                                <ul class="action d-flex gap-2 flex-wrap flex-md-nowrap">
                                                    <li class="">
                                                        <a href="{{ route('dokument.atlet', $person['id']) }}" title="Dokumen" class="btn btn-link p-0 m-0 text-success">
                                                            <i class="icon-file"></i>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="{{ route('form.atlet.edit', $person['id']) }}" title="Edit" class="btn btn-link p-0 m-0 text-purple">
                                                            <i class="icon-pencil-alt"></i>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <form onsubmit="return deletePerson(event, '{{ route('web.people.destroy', $person['id']) }}', '{{ $person['id'] }}')">
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
function deletePerson(event, url, id) {
    event.preventDefault();

    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        buttons: ["Batal", "Ya, hapus!"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    '_method': 'DELETE'
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal menghapus data.');
                document.getElementById(`person-row-${id}`).remove();
                Swal.fire("Berhasil!", "Data berhasil dihapus.", "success");
            })
            .catch(error => {
                Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data.", "error");
                console.error(error);
            });
        }
    });

    return false;
}
</script>


@endsection


