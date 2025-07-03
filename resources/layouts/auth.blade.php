<!DOCTYPE html>
<html lang="en">

<head>
    @include('components::header')
    @yield('headScripts')
</head>

<body>
    @yield('content')
    @include('components::footer')
    @yield('footScripts')
</body>

</html>