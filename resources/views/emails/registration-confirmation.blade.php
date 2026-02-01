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
    
</head>

<body>

    <h1>Dear Graduate, Congratulations!</h1>
    <p>We are excited to inform you that your registration for the NDUB 2nd Convocation 2025 has been confirmed. Please log in 
    to your account on the NDUB Convocation portal to download your <b>‘Student Copy’</b> document.</p>
    <p>NDUB Convocation portal: <a href="https://convocation.ndub.edu.bd">https://convocation.ndub.edu.bd</a></p>
    <p>You must retain the ‘Student Copy’ document for future reference until the Official Certificate is received. 
    The future uses of the <b>‘Student Copy’</b> are as follows:</p>
    <ol>
        <li>Photo Session</li>
        <li>Entry Pass Collection</li>
        <li>Gown Receiving</li>
        <li>Gift Receiving</li>
        <li>Food Coupon Receiving</li>
        <li>Gown Returning</li>
        <li>Official Certificate Receiving</li>
    </ol>
    <p>Best regards,</p>
    <p>NDUB Convocation Registration Team</p>
    
</body>
</html>
