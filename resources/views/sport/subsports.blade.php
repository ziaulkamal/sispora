@extends('layouts::admin')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center" style="gap: 0.5rem;">
                    <h3 class="mb-0">{{ ucwords($title) ?? null }}</h3>
                    <a href="{{ route('view.sport.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">{{ ucwords($section) ?? null }}</li>
                        <li class="breadcrumb-item active"> {{ ucwords($sport['name']) ?? null }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid email-wrap bookmark-wrap todo-wrap">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 box-col-30">
                <div class="email-sidebar md-sidebar">
                    <a class="btn btn-primary email-aside-toggle md-sidebar-toggle">Detail</a>
                    <div class="email-left-aside md-sidebar-aside">
                        <div class="card">
                            <div class="card-body">
                                <div class="email-app-sidebar left-bookmark custom-scrollbar">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="f-w-600">Detail Cabor</h6>
                                        </div>
                                    </div>
                                    <ul class="nav main-menu">
                                        <li class="nav-item">
                                            <button class="btn-primary badge-light d-block btn-mail w-100">
                                                <i class="me-2" data-feather="check-circle"></i>{{ strtoupper($sport['name']) }}
                                            </button>
                                        </li>
                                        <li class="nav-item"><a href="javascript:void(0)">
                                            <span class="iconbg badge-light-success"><i data-feather="check-circle"></i></span>
                                            <span class="title ms-2">Active</span>
                                            <span class="badge rounded-pill badge-success" id="active-count">
                                                {{ $sport->subSports->count() }}
                                            </span>
                                        </a></li>
                                        <li class="nav-item"><a href="javascript:void(0)">
                                            <span class="iconbg badge-light-warning"><i data-feather="clock"></i></span>
                                            <span class="title ms-2">Progress</span>
                                            <span class="badge rounded-pill badge-warning" id="progress-count">0</span>

                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-xl-8 box-col-70">
                <div class="card">
                    <div class="card-header b-bottom">
                        <div class="todo-list-header">
                            <div class="new-task-wrapper input-group">
                                <input type="hidden" id="sportId" value="{{ $sport->id }}">
                                <input class="form-control" id="new-task" placeholder="Tambah Kelas Cabang Olahraga">
                                <span class="btn btn-primary add-new-task-btn" id="add-task">Kirim Kelas Baru</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="todo">
                            <div class="todo-list-wrapper theme-scrollbar">
                                <div class="todo-list-container">
                                    <div class="todo-list-body">
                                        <ul id="todo-list">
                                            @forelse($sport->subSports as $sub)
                                                 <li class="task" data-id="{{ $sub->id }}" data-source="db">
                                                    <div class="task-container">
                                                        <h4 class="task-label">{{ $sub->name }}</h4>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="badge badge-light-success">Active</span>
                                                            <h5 class="assign-name m-0">{{ $sub->created_at?->format('d M') ?? '-' }}</h5>
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
@endsection

@section('footScripts')
<script>
    let progressCount = 0;

    function updateProgressCount() {
        $('#progress-count').text(progressCount);
    }
    $('#add-task').on('click', function () {
        const sportId = $('#sportId').val();
        const name = $('#new-task').val();
        const storeData = "{{ route('web.sports.subs.store') }}";

        if (!name.trim()) return alert('Nama kelas tidak boleh kosong');

        $.ajax({
            url: storeData,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                sportId: sportId,
                name: name,
                label: null
            },
            success: function (res) {
                $('#new-task').val('');
                progressCount++;
                updateProgressCount();
                $('#empty-message').hide();
                $('#todo-list').append(`
                <li class="task" data-id="${res.data.id}" data-source="js">
                    <div class="task-container">
                        <h4 class="task-label">${res.data.name}</h4>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-light-warning">In Progress</span>
                            <h5 class="assign-name m-0">{{ now()->format('d M') }}</h5>
                            <span class="task-action-btn">
                                <span class="action-box large delete-btn" title="Delete Task">
                                    <i class="icon"><i class="icon-trash"></i></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </li>
            `);
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal menyimpan kelas';
                alert(msg);
            }
        });
    });

    // Delete task event
    $(document).on('click', '.delete-btn', function () {
        const task = $(this).closest('.task');
        const id = task.data('id');
        const source = task.data('source'); // 'db' atau 'js'
        let removeData = "{{ route('web.sports.subs.destroy', ['id' => ':id']) }}";
        removeData = removeData.replace(':id', id);
        if (!task) {
            Swal.fire('Oops!', 'ID kelas tidak ditemukan.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data kelas akan dihapus dan tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: removeData,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        task.remove();

                        if (source === 'db') {
                            const activeCountEl = $('#active-count');
                            let count = parseInt(activeCountEl.text());
                            if (count > 0) activeCountEl.text(count - 1);
                        } else {
                            const progressCountEl = $('#progress-count');
                            let progress = parseInt(progressCountEl.text());
                            if (progress > 0) progressCountEl.text(progress - 1);
                        }

                        // ✅ Cek apakah masih ada item task tersisa
                        if ($('#todo-list .task').length === 0) {
                            $('#empty-message').show();
                        }

                        // ✅ Tampilkan alert sukses
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data kelas berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus kelas.';
                        Swal.fire('Gagal!', msg, 'error');
                    }
                });
            }
        });
    });

</script>
@endsection


