<!DOCTYPE html>
<html lang="en">

<head>
    @include('components::header')
    @yield('headScripts')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7"><img class="bg-img-cover bg-center" src="{{ asset('assets') }}/images/login/2.jpg"
                    alt="looginpage"></div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div class="login-main">
                            <form class="theme-form">
                                <h4 class="text-center">PORA XV AUTH</h4>
                                <p class="text-center">Akses dengan credential yang telah diberikan.</p>
                                <div class="form-group">
                                    <label class="col-form-label">Nomor Induk KTP</label>
                                    <input class="form-control" type="text" required="" placeholder="Nomor Induk KTP">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="login[password]" required=""
                                            placeholder="*********">
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    {{-- <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div><a class="link" href="#">Forgot password?</a> --}}
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Login</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components::footer')
    @yield('footScripts')
</body>

</html>