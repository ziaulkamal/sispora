<!DOCTYPE html>
<html lang="en">
    <head>
        @include('components::header')
        @yield('headScripts')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
<body>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('components::loader')

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <div class="page-header">
            <div class="header-wrapper row m-0">

            @include('components::headerLogo')
            @include('components::adminTopNav')
            </div>
        </div>

        <div class="page-body-wrapper horizontal-menu">
            @include('components::adminSidebarNav')
            @yield('content')
            @include('components::adminCopyright')
        </div>
    </div>
    @include('components::footer')
    @yield('footScripts')
    @yield('load-mendagri-js')
    <script>
        function triggerLogout() {
            Swal.fire({
                title: 'Yakin mau logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>
</html>