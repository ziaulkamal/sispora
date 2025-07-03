<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - {{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/icofont.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/themify.css">
    <link id="color" rel="stylesheet" href="{{ asset('assets') }}/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/flag-icon.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/responsive.css">
  </head>
  <body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="loader-wrapper">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"> </div>
      <div class="dot"></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <div class="error-wrapper">
        <div class="container">
          <div class="col-md-8 offset-md-2">
            <h2>ERROR 405</h2>
            <p class="sub-content">Sepertinya anda tersesat, silahkan kembali kedalam Aplikasi</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali</a>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('assets') }}/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/icons/feather-icon/feather-icon.js"></script>
    <script src="{{ asset('assets') }}/js/config.js"></script>
    <script src="{{ asset('assets') }}/js/script.js"></script>
  </body>
</html>