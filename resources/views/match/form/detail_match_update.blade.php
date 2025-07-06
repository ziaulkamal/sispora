@extends('layouts::admin')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
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
        <div class="user-profile">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 box-col-70">
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
                <div class="col-xxl-12 col-xl-12 box-col-80">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header">
                                <h5>Update Hasil Pertandingan</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kontingen</th>
                                                @if($schedule['special_case'] === 'yes')
                                                    <th>Babak</th>
                                                    <th>Group</th>
                                                @else
                                                    <th>Type Score</th>
                                                @endif
                                                <th width="30%">Score</th>
                                                <th >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schedule['additional_schedules'] as $idx => $item)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item['id'] }}">
                                                        {{ $item['kontingenName'] ?? '-' }}
                                                    </td>

                                                    @if($schedule['special_case'] === 'yes')
                                                        <td>
                                                            <select name="items[{{ $idx }}][match]" class="form-select">
                                                                <option value="qualified" @selected($item['match'] == 'qualified')>Penyisihan</option>
                                                                <option value="group" @selected($item['match'] == 'group')>Group</option>
                                                                <option value="grandfinal" @selected($item['match'] == 'grandfinal')>Final</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="items[{{ $idx }}][group]" class="form-control" value="{{ $item['group'] }}">
                                                        </td>
                                                    @else
                                                        <td>
                                                            <select name="items[{{ $idx }}][typeScore]" class="form-select">
                                                                <option value="minutes" @selected($item['typeScore'] == 'minutes')>Menit</option>
                                                                <option value="weight" @selected($item['typeScore'] == 'weight')>Berat</option>
                                                                <option value="distance" @selected($item['typeScore'] == 'distance')>Jarak</option>
                                                                <option value="default" @selected($item['typeScore'] == 'default') disabled>Default</option>
                                                            </select>
                                                        </td>
                                                    @endif

                                                    <td>
                                                        <input type="number" step="0.01" name="items[{{ $idx }}][score]" class="form-control" value="{{ $item['score'] }}">
                                                    </td>

                                                    <td>
                                                        <select name="items[{{ $idx }}][status]" class="form-select">
                                                            <option value="default" @selected($item['status'] == 'default') disabled>Default</option>
                                                            <option value="win" @selected($item['status'] == 'win')>Menang</option>
                                                            <option value="lose" @selected($item['status'] == 'lose')>Kalah</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
