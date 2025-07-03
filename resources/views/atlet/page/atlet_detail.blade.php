@extends('layouts::admin')

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
                                                    <div class="icon"><i data-feather="user"></i></div>
                                                    <div>
                                                        <h5>{{ $person['fullName'] }}</h5>
                                                        <p class="mb-0">{{ $person['gender'] }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="calendar"></i></div>
                                                    <div>
                                                        <h5>Tanggal Lahir / Usia</h5>
                                                        <p class="mb-0">{{ $person['birthdate'] }} ({{ $person['age'] }})</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="map-pin"></i></div>
                                                    <div>
                                                        <h5>Alamat</h5>
                                                        <p class="mb-0">
                                                            {{ $person['streetAddress'] }},
                                                            {{ $person['village'] }},
                                                            {{ $person['district'] }},
                                                            {{ $person['regency'] }},
                                                            {{ $person['province'] }}
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="phone"></i></div>
                                                    <div>
                                                        <h5>Nomor Handphone</h5>
                                                        <p class="mb-0">{{ $person['phoneNumber'] }}</p>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="icon"><i data-feather="activity"></i></div>
                                                    <div>
                                                        <h5>Tinggi / Berat Badan</h5>
                                                        <p class="mb-0">{{ $person['height'] }} / {{ $person['weight'] }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="droplet"></i></div>
                                                    <div>
                                                        <h5>Agama</h5>
                                                        <p class="mb-0">{{ $person['religion'] }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon"><i data-feather="map"></i></div>
                                                    <div>
                                                        <h5>Kontingen</h5>
                                                        <p class="mb-0">{{ $kontingen->regency->name }}</p>
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
                        <div class="card-header b-bottom">
                            <div class="todo-list-header">
                                <div class="new-task-wrapper input-group">
                                    <input type="hidden" id="peopleId" value="{{ $person['id'] }}">
                                    <input type="hidden" id="kontingenId" value="{{ $kontingen['id'] }}">
                                    <select id="kelas-cabang" class="form-select">
                                        <option value="">Pilih Kelas Cabang Olahraga</option>
                                    </select>
                                    <span class="btn btn-primary add-new-task-btn" id="add-task"><div id="text" style="position:relative; top:4px;">Daftarkan Unit Kelas Cabor</div></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="todo">
                                <div class="todo-list-wrapper theme-scrollbar">
                                    <div class="todo-list-container">
                                        <div class="todo-list-body">
                                            <ul id="todo-list">
                                            @forelse($person['athletes'] as $athlete)
                                                <li class="task" data-id="{{ $athlete['id'] }}" data-source="db">
                                                    <div class="task-container">
                                                        <h4 class="task-label">[{{ $athlete['sportsSub']['sport']['name'] ?? 'Tanpa Label' }}]{{ $athlete['sportsSub']['name'] }}</h4>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="badge badge-light-success">Active</span>
                                                            <span class="task-action-btn">
                                                                <span class="action-box large delete-btn" title="Delete Task">
                                                                    <i class="icon"><i class="icon-trash"></i></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="task" id="empty-message">
                                                    <div class="task-container">
                                                        <h4 class="task-label text-muted">Belum ada kelas</h4>
                                                    </div>
                                                </li>
                                            @endforelse
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
<script>
$(document).ready(function(){
    let sportsUrl = "{{ route('web.sports.index') }}";
    console.log(sportsUrl);

    $.ajax({
        url: sportsUrl,
        type: 'GET',
        success: function(data) {
            let select = $('#kelas-cabang');
            select.empty();
            select.append('<option value="">Pilih Kelas Cabang Olahraga</option>');

            data.forEach(function(sport){
                if (sport.sub_sports && sport.sub_sports.length > 0) {
                    let optgroup = $('<optgroup>').attr('label', sport.name);
                    sport.sub_sports.forEach(function(sub){
                        optgroup.append(
                            $('<option>').val(sub.id).text(sub.name)
                        );
                    });
                    select.append(optgroup);
                } else {
                    select.append(
                        $('<option disabled>').text(sport.name + ' (Tidak ada kelas)')
                    );
                }
            });
        },
        error: function(xhr) {
            console.error('Gagal mengambil data:', xhr);
        }
    });

    $('#add-task').on('click', function(){
        let atheleteSubmit = "{{ route('web.athletes.index') }}";
        let peopleId = $('#peopleId').val();
        let kontingenId = $('#kontingenId').val();
        let sportsSubId = $('#kelas-cabang').val();

        if (!sportsSubId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih kelas cabang olahraga terlebih dahulu.'
            });
            return;
        }

        $.ajax({
            url: atheleteSubmit,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                peopleId: peopleId,
                sportsSubId: sportsSubId
            },
            success: function (res) {
                $('#empty-message').remove(); // hapus pesan kosong

                const sportName = res.sportName || 'Tanpa Label';

                $('#todo-list').append(`
                    <li class="task" data-id="${res.id}" data-source="js">
                        <div class="task-container">
                            <h4 class="task-label">[${sportName}]${res.sportsSubName}</h4>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge badge-light-success">Active</span>
                                <span class="task-action-btn">
                                    <span class="action-box large delete-btn" title="Delete Task">
                                        <i class="icon"><i class="icon-trash"></i></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </li>
                `);
                 Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Atlet berhasil ditambahkan.'
                });
            },
            error: function(xhr){
                let msg = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: msg
                });
            }
        });
    });

   $(document).on('click', '.delete-btn', function(){
       let li = $(this).closest('.task');
       let id = li.data('id');
       let atheleteDelete = "{{ route('web.athletes.destroy', ['id' => ':id']) }}";
       atheleteDelete = atheleteDelete.replace(':id', id);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: atheleteDelete,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(){
                        li.remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Atlet berhasil dihapus.'
                        });
                    },
                    error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus data.'
                        });
                    }
                });
            }
        });
    });
});
</script>


@endsection
