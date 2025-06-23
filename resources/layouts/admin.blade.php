<!DOCTYPE html>
<html lang="en">
    <head>
        @include('components::header')
        @yield('headScripts')
    </head>
<body>

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
</body>
</html>