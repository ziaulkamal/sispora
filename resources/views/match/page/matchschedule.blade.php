@extends('layouts::admin')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.schedule.insert') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
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
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Kelas Olahraga</th>
                                        <th>Venue Pertandingan</th>
                                        <th>Status Pelaksanaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule['date'] }}</td>
                                        <td>{{ $schedule['start_time'] }}</td>
                                        <td>{{ $schedule['end_time'] }}</td>
                                        <td>{{ $schedule['sports_sub']['sport']['name'] }} - {{ $schedule['sports_sub']['name'] ?? '-' }}</td>
                                        <td>{{ $schedule['venue']['name'] ?? '-' }}</td>
                                        <td>
                                            @switch($schedule['status_pelaksanaan'])
                                                @case('belum dilaksanakan')
                                                    <span class="badge bg-danger text-light">Belum Terlaksana</span>
                                                    @break

                                                @case('sedang berlangsung')
                                                    <span class="badge bg-primary text-light">Sedang Berlangsung</span>
                                                    @break

                                                @case('selesai')
                                                    <span class="badge bg-success text-light">Telah Selesai</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <ul class="action d-flex gap-2 flex-wrap flex-md-nowrap">
                                                <li>
                                                    <a href="{{ route('view.schedule.detail', ['id' => $schedule['id']]) }}"
                                                    class="btn btn-link p-0 m-0 text-success open-subsport-modal me-2"
                                                    title="Detail">
                                                    <i data-feather="eye" class="fs-7"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('view.schedule.wasit.update', ['id' => $schedule['id']]) }}"
                                                    class="btn btn-link p-0 m-0 text-warning open-subsport-modal me-2"
                                                    title="Wasit">
                                                    <i data-feather="search" class="fs-7"></i>
                                                    </a>
                                                </li>

                                                {{-- <li>
                                                    <form onsubmit="return deleteSports(event, '{{ route('web.sports.destroy', $sports['id']) }}', '{{ $sports['id'] }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 m-0 text-danger" title="Hapus">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </form>
                                                </li> --}}
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

</script>


@endsection

