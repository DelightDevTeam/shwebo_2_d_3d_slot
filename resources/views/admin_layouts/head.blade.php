<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ 'admin_app/assets/img/apple-icon.png' }}">
    <link rel="icon" href="{{ asset('/assets/img/logo.png') }}">
    <title>
        ShweBo 2D 3D Slot
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('admin_app/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_app/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/b829c5162c.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    {{-- <link id="pagestyle" href="{{ asset('admin_app/assets/css/material-dashboard.css?v=3.0.6')}}" rel="stylesheet" /> --}}
    <link id="pagestyle" href="{{ asset('admin_app/assets/css/material-dashboard.css?v=3.0.6') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="{{ asset('admin_app/assets/css/setting.css') }}" rel="stylesheet" />

    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    {{-- <script defer data-site="https://delightmyanmar.online" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> --}}
</head>
