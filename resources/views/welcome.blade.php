<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('contents/admin/') }}/assets/img/ndub.png">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
            rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('contents/admin/') }}/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Tempusdominus Bootstrap 4 -->
    <link href="{{ asset('contents/admin/') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('contents/admin/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('contents/admin/') }}/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('contents/admin/') }}/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- overlayScrollbars -->

    <link href="{{ asset('contents/admin/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"
        rel="stylesheet">

    <!-- Daterange picker -->
    <link href="{{ asset('contents/admin/') }}/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- summernote -->
    <link href="{{ asset('contents/admin/') }}/plugins/summernote/summernote-bs4.min.css" rel="stylesheet">

    <link href="{{ asset('contents/admin/assets') }}/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('contents/admin/assets') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('contents/admin/assets') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('contents/admin/assets') }}/css/jquery.dataTables.min.css" rel="stylesheet">


    <script src="{{ asset('contents/admin/assets') }}/js/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('contents/admin/assets') }}/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('contents/admin/assets') }}/js/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>

    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        referrerpolicy="no-referrer" rel="stylesheet" />
        
    <style>
        .index_body_class{
            background-image: url("{{ asset('contents/admin/') }}/assets/img/convocation1.jpg");
            /* background-size: cover; */
            background-size: 100% 110%;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white; /* Text color on the overlay */
            }
    </style>
    
</head>

<body class="index_body_class">
    <header style="padding:0px; margin:0px; width:100%;">
    <div class="container-fluid header_container" style="padding:0px; margin:0px; width:100%;">
        <div class="row p-3 mb-3 index_header_row" style="padding:0px; margin:0px; width:100%;">
            <div class="col-12 col-md-10" style="padding:0px; margin:0px;">
                <h1 class="text-left index_header_text" style=" font-size:28px;">NDUB Alumni Portal</h1>
            </div>
            <div class="col-12 col-md-2" style="padding:0px; margin:0px;">
            @if (Route::has('login'))
            @auth
                <a class="btn btn-light btn-sm mb-1" href="{{ url('/dashboard') }}" style="padding:4px; margin:1px;">Dashboard</a>
            @else
                <a class="btn btn-light btn-sm mb-1" href="{{ route('login') }}" style="padding:4px; margin:1px;">Sign In</a>
            @if (Route::has('register'))
                <a class="btn btn-light btn-sm mb-1" href="{{ route('register') }}" style="padding:4px; margin:1px;">Register </a>
            @endif
            @endauth
            @endif
            
            </div>
        </div>
    </div>
    </header>
    
    <section>
        <div class="container">
        <div class="row text-center">
            <div class="col-12 col-md-12">
                <br>
                <br>
                <br>
                <br>
                <br>
                <img src="{{ asset('contents/admin/') }}/assets/img/ndub.png" alt="" class="img-fluid" width="200px">
                
                <h1 class="text-center font-weight-bold" style="font-size: 54px; color:#AE9142;">Notre Dame University Bangladesh</h1><br><br>
            </div>

            <div class="row text-center">
                <div class="col-12 col-md-12"><h1 class="text-center text-primary font-weight-bold"></h1></div>
            </div>
        </div>
        </div>
    </section>
    
    

    
</body>
</html>
