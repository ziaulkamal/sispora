@extends('layouts::admin')
{{-- @dd($schedule) --}}
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
        <div class="user-profile">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 box-col-70">
                    <div class="default-according style-1 job-accordion">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="p-0">
                                            <button class="btn btn-link ps-0" data-bs-toggle="collapse"
                                                data-bs-target="#collapseicon2" aria-expanded="true"
                                                aria-controls="collapseicon2">Detail</button>
                                        </h5>
                                    </div>
                                    <div class="collapse show" id="collapseicon2" aria-labelledby="collapseicon2"
                                        data-parent="#accordion">
                                        <div class="card-body post-about">
                                            <ul>
                                                <li>
                                                    <div class="icon"><i data-feather="award" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Olahraga yang Dipertandingkan</h5>
                                                        <p class="mb-0">{{ $schedule['sports_sub']['sport']['name'] ?? '-' }} ({{ $schedule['sports_sub']['name'] ?? '-' }})</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="map-pin" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Lokasi Venue</h5>
                                                        <p class="mb-0">
                                                            @if(!empty($schedule['venue']['latitude']) && !empty($schedule['venue']['longitude']))
                                                                <a
                                                                    href="https://www.google.com/maps/search/?api=1&query={{ $schedule['venue']['latitude'] }},{{ $schedule['venue']['longitude'] }}"
                                                                    target="_blank"
                                                                    class="btn btn-xs btn-outline-primary"
                                                                    title="Lihat di Google Maps"
                                                                >
                                                                    {{ $schedule['venue']['name'] ?? '-' }}
                                                                </a>
                                                            @else
                                                                {{ $schedule['venue']['name'] ?? '-' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="calendar" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Tanggal</h5>
                                                        <p class="mb-0">{{ $schedule['date'] ?? '-' }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="clock" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Waktu Mulai / Waktu Berakhir</h5>
                                                        <p class="mb-0">{{ $schedule['start_time'] ?? '-' }} - {{ $schedule['end_time'] ?? '-' }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="users" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Kontingen Terlibat</h5>
                                                        <p class="mb-0">{{ $schedule['kontingen_count'] ?? '0' }} Kontingen</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="activity" style="width:16px;height:16px;"></i></div>
                                                    <div>
                                                        <h5>Status Pelaksanaan</h5>
                                                        <p class="mb-0 text-capitalize">{{ $schedule['status_pelaksanaan'] ?? '-' }}</p>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-8 box-col-80">
                    <div class="card">
                        <div class="card-body">
                            <div class="todo">
                                <div class="todo-list-wrapper theme-scrollbar">
                                    <div class="todo-list-container">
                                        <div class="todo-list-body">
                                            <ul id="todo-list">
    @foreach($schedule['additional_schedules'] as $item)
                                                {{-- @dd($item) --}}
                                                    <li class="d-flex flex-column mb-3 p-3 border rounded">
                                                        <div><strong>Kontingen:</strong> {{ $item['kontingenName'] ?? '-' }}</div>

                                                        @if($schedule['special_case'] === 'no')
                                                            <div><strong>Type Score:</strong> {{ $item['typeScore'] ?? '-' }}</div>
                                                        @else
                                                            <div><strong>Babak:</strong> {{ $item['match'] ?? '-' }}</div>
                                                            <div><strong>Group:</strong> {{ $item['group'] ?? '-' }}</div>
                                                        @endif

                                                        <div><strong>Score:</strong> {{ $item['score'] ?? '-' }}</div>
                                                        <div>
                                                            <strong>Status:</strong>
                                                            <span class="badge
                                                                @if($item['status'] === 'win') bg-success
                                                                @elseif($item['status'] === 'lose') bg-danger
                                                                @else bg-secondary
                                                                @endif
                                                            ">
                                                                {{ ucfirst($item['status']) }}
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endforeach
</ul>


                                        </div>
                                    </div>
                                </div>
                                <div class="notification-popup hide">
                                    <p><span class="task"></span><span class="notification-text"></span></p>
                                </div>
                            </div>
                            <!-- End Task Template -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footScripts')



@endsection
