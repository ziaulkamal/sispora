@extends('layouts::auth')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/2.jpg') }}" alt="loginpage">
        </div>
        <div class="col-xl-5 p-0">
            <div class="login-card">
                <div>
                    <div class="login-main">
                        <form class="theme-form" method="POST" action="{{ route('login.attempt') }}">
                            @csrf

                            <h4 class="text-center">PORA XV AUTH</h4>
                            <p class="text-center">Akses dengan credential yang telah diberikan.</p>

                            <!-- radio button -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="login_method" id="login_nik" value="nik" checked>
                                    <label class="form-check-label" for="login_nik">Login dengan NIK</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="login_method" id="login_username" value="username">
                                    <label class="form-check-label" for="login_username">Login dengan Username</label>
                                </div>
                            </div>

                            <!-- dynamic input -->
                            <div class="form-group">
                                <label class="col-form-label" id="login_label">Nomor Induk KTP</label>
                                <input class="form-control" type="text" name="nik" id="login_input" required placeholder="Nomor Induk KTP">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <input class="form-control" type="password" name="password" required placeholder="*********">
                            </div>

                            <div class="form-group mb-0">
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

{{-- SweetAlert2 --}}

{{-- Script dinamis label + placeholder --}}

@endsection

@section('footScripts')
<script>
$(document).ready(function() {
    const $loginInput = $('#login_input');
    const $loginLabel = $('#login_label');

    $('#login_nik').on('change', function() {
        $loginInput.attr({
            'name': 'nik',
            'placeholder': 'Nomor Induk KTP'
        }).val('') // kosongkan input
          .removeClass('maxchar-25')
          .addClass('onlynumber maxchar-16');

        $loginLabel.text('Nomor Induk KTP');
    });

    $('#login_username').on('change', function() {
        $loginInput.attr({
            'name': 'username',
            'placeholder': 'Username'
        }).val('') // kosongkan input
          .removeClass('onlynumber maxchar-16')
          .addClass('maxchar-25');

        $loginLabel.text('Username');
    });

    // trigger initial state saat page load
    if ($('#login_nik').is(':checked')) {
        $loginInput.addClass('onlynumber maxchar-16').val('');
    } else if ($('#login_username').is(':checked')) {
        $loginInput.addClass('maxchar-25').val('');
    }
});
</script>




@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    });
</script>
@endif

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    });
</script>
@endif

@endsection