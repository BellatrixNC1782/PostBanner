<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

<!-- Meta Data -->
<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title> Fans Play Louder </title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
<meta name="Author" content="Spruko Technologies Private Limited">
<meta name="keywords" content="dashboard,admin,template dashboard,html css templates,admin panel,admindashboard,dashboard bootstrap 5,html and css,bootstrap admin dashboard,bootstrap 5 admin template,admin panel bootstrap template,admin dashboard,html template,dashboard,template,bootstrap">

<!-- Favicon -->
<link rel="icon" href="{{ asset('public/images/fav.png') }}" type="image/x-icon">

<!-- Choices JS -->
<script src="{{ asset('public/admin/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

<!-- Main Theme Js -->
<script src="{{ asset('public/admin/assets/js/main.js') }}"></script>

<!-- Bootstrap Css -->
<link id="style" href="{{ asset('public/admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

<!-- Style Css -->
<link href="{{ asset('public/admin/assets/css/styles.min.css') }}" rel="stylesheet" >

<!-- Custom Css -->
<link href="{{ asset('public/admin/assets/css/custom.css') }}" rel="stylesheet" >

<!-- Icons Css -->
<link href="{{ asset('public/admin/assets/css/icons.css') }}" rel="stylesheet" >

<!-- Node Waves Css -->
<link href="{{ asset('public/admin/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" > 

<!-- Simplebar Css -->
<link href="{{ asset('public/admin/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >

<!-- Color Picker Css -->
<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

<!-- Choices Css -->
<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">


<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">

<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/swiper/swiper-bundle.min.css') }}">
<!-- Alertify -->
<link rel="stylesheet" href="{{ asset('public/admin/assets/css/alertify.min.css')}}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/quill/quill.bubble.css')}}">
<!-- FlatPickr CSS -->
<link rel="stylesheet" href="{{ asset('public/admin/assets/libs/flatpickr/flatpickr.min.css')}}">
@yield('stylesheet')
<style>
    .flatpickr-day.today {
        background-color: transparent !important; /* Remove default background color */
        color: inherit !important; /* Keep text color as default */
    }
</style>
<!--<style>
    button.editor-source-button {
        margin: .25rem;
        border: 1px solid var(--default-border) !important;
        border-radius: 0.5rem;
        width: auto !important;
        height: unset !important;
    }
</style>-->
</head>

<body>
@include('admincp.switcher')
    <!-- Loader -->
    <div id="loader" >
        <img src="{{ asset('public/admin/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
         <!-- app-header -->
         <header class="app-header">
            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">
                <!-- Start::header-content-left -->
                <div class="header-content-left">
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar">
                            <a class="open-toggle" href="javascript:void(0);">
                                <i class="header-link-icon fe fe-align-left fs-16"></i>
                            </a>
                            <a class="close-toggle" href="javascript:void(0);">
                                <i class="header-link-icon fe fe-x"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->
                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">
                    <div class="header-element header-theme-mode">
                    </div>
                    <div class="header-element">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="me-0">
                                    @if(!empty(Auth::guard('admin')->User()->image))
                                        <img src="<?php echo App\Models\Common::getS3PublicUrl(Auth::guard('admin')->User()->image); ?>" alt="User Image" width="32" height="32" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('public/images/default.png') }}" alt="img" width="32" height="32" class="rounded-circle">
                                    @endif
                                </div>
                            </div>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <div class="main-header-dropdown dropdown-menu header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                            <div class="p-3 text-center">
                                <h6 class="fw-semibold mb-0 lh-1">{{Auth::guard('admin')->User()->first_name.' '.Auth::guard('admin')->User()->last_name}}</h6>
                            </div>
                            <div class="dropdown-divider m-0"></div>
                            <ul class="list-unstyled mb-0">
                                <li class="dropdown-item"><a class="d-flex" href="{{route('profile')}}"><i class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile Management</a></li>
                                <li class="dropdown-item"><a class="d-flex" href="{{route('admincplogout')}}"><i class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                            </ul>
                        </div>
                    </div>  
                    <!-- End::header-element -->
                </div>
                <!-- End::header-content-right -->
                
            </div>
            <!-- End::main-header-container -->
        </header>
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">
            <?php $current_route = Route::currentRouteName();?>
             <!--Start::main-sidebar-header--> 
            <div class="main-sidebar-header">
                <a class="header-logo">
                    <img src="{{ asset('public/images/logo.svg') }}" alt="logo" class="desktop-logo">
                    <img src="{{ asset('public/images/logo.svg') }}" alt="logo" class="toggle-logo">
                    <img src="{{ asset('public/images/logo.svg') }}" alt="logo" class="desktop-dark">
                    <img src="{{ asset('public/images/logo.svg') }}" alt="logo" class="toggle-dark">
                </a>
            </div>
             <!--End::main-sidebar-header--> 

             <!--Start::main-sidebar--> 
            <div class="main-sidebar" id="sidebar-scroll">

                 <!--Start::nav--> 
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="app-sidebar__user clearfix">
                        <div class="dropdown user-pro-body">
                            <div class="user-pic">
                                <span class="avatar avatar-xxl avatar-rounded">
                                    @if(!empty(Auth::guard('admin')->User()->image))
                                        <img src="<?php echo App\Models\Common::getS3PublicUrl(Auth::guard('admin')->User()->image); ?>" class="mb-1" alt="User Image">
                                    @else
                                        <img src="{{ asset('public/images/default.png') }}" alt="user-img" class="mb-1">
                                    @endif
                                </span>
                            </div>
                            <div class="user-info">
                                <h5 class="fs-16 mb-1">{{Auth::guard('admin')->User()->first_name.' '.Auth::guard('admin')->User()->last_name}} <i class="ion-checkmark-circled  text-success fs-12"></i></h5>
                            </div>
                        </div>
                    </div>
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                    </div>
                    <ul class="main-menu"> 
                        <?php
                        $dashboardActive = '';
                        if($current_route == 'dashboard'){
                            $dashboardActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $dashboardActive }}">
                            <a href="{{ route('dashboard') }}" class="side-menu__item {{ $dashboardActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        
                        <?php
                        $usermanagemaentActive = '';
                        if($current_route == 'userlist'
                                || $current_route == 'viewuser'
                                || $current_route == 'alumnilist'){
                            $usermanagemaentActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $usermanagemaentActive }}">
                            <a href="{{ route('userlist') }}" class="side-menu__item {{ $usermanagemaentActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm-8 0c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                <span class="side-menu__label">User Management</span>
                            </a>
                        </li>
                        <?php
                        $interaction = '';
                        if ($current_route == 'interaction' 
                                || $current_route == 'addinteraction' 
                                || $current_route == 'editinteraction') {
                            $interaction = 'active';
                        }
                        ?>
                        <li class="slide {{ $interaction }}">
                            <a href="{{route('interaction')}}" class="side-menu__item {{ $interaction }} ">
                                <svg class="side-menu__icon" fill="#000000" width="800px" height="800px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="icon">
                                    <path d="M880 112H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V144c0-17.7-14.3-32-32-32zm-40 728H184V184h656v656zM304.8 524h50.7c3.7 0 6.8-3 6.8-6.8v-78.9c0-19.7 15.9-35.6 35.5-35.6h205.7v53.4c0 5.7 6.5 8.8 10.9 5.3l109.1-85.7c3.5-2.7 3.5-8 0-10.7l-109.1-85.7c-4.4-3.5-10.9-.3-10.9 5.3V338H397.7c-55.1 0-99.7 44.8-99.7 100.1V517c0 4 3 7 6.8 7zm-4.2 134.9l109.1 85.7c4.4 3.5 10.9.3 10.9-5.3v-53.4h205.7c55.1 0 99.7-44.8 99.7-100.1v-78.9c0-3.7-3-6.8-6.8-6.8h-50.7c-3.7 0-6.8 3-6.8 6.8v78.9c0 19.7-15.9 35.6-35.5 35.6H420.6V568c0-5.7-6.5-8.8-10.9-5.3l-109.1 85.7c-3.5 2.5-3.5 7.8 0 10.5z"/>
                                </svg>
                                <span class="side-menu__label">Interaction Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $merchandise = '';
                        if ($current_route == 'merchandisesize' 
                                || $current_route == 'addmerchandise' 
                                || $current_route == 'editmerchandise') {
                            $merchandise = 'active';
                        }
                        ?>
                        <li class="slide {{ $merchandise }}">
                            <a href="{{route('merchandisesize')}}" class="side-menu__item {{ $merchandise }} ">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></svg>
                                <span class="side-menu__label">Merchandise Management</span>
                            </a>
                        </li>


                        <?php
                        $subscription = '';
                        if($current_route == 'subscription' ||
                            $current_route == 'addsubscription' ||
                            $current_route == 'editsubscription'){
                            $subscription = 'active';
                        }
                        ?>
                        <li class="slide {{ $subscription }}">
                            <a href="{{ route('subscription') }}" class="side-menu__item {{ $subscription }}">
                                <svg class="side-menu__icon" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.68 122.88"><title>discount-voucher</title><path d="M100.87,60.09c-5.65-8.65-9.59-14.76-13.78-21.23-2.2-3.41-4.48-6.93-7.44-11.48l-1.3.85a2.7,2.7,0,0,1-4-3.12,2.64,2.64,0,0,1,1.08-1.4l1.31-.86c-3-4.68-6.77-10.39-11.59-17.77a.68.68,0,0,0-.41-.28.71.71,0,0,0-.49.09L62,6.32a10.12,10.12,0,0,1,.45,5.75,10.24,10.24,0,0,1-4.36,6.44l-.07.06A10.31,10.31,0,0,1,45.34,17.4L43,18.86a10.3,10.3,0,0,1,.48,5.56A10.13,10.13,0,0,1,39.09,31l-.37.24a10.09,10.09,0,0,1-7.58,1.28,10.39,10.39,0,0,1-5-2.71l-2.93,1.91a.65.65,0,0,0-.24.38.68.68,0,0,0,0,.42l.1.16c4.7,7.19,8.39,12.93,11.47,17.72l.08,0,4.52-3a2.7,2.7,0,0,1,4,3.12,2.74,2.74,0,0,1-1.08,1.4l-4.52,2.95-.12.07c1.13,1.77,2.22,3.46,3.35,5.19Zm-65.68,0-3.85-6c-3.1-4.83-6.85-10.67-12.25-18.94h0a5.43,5.43,0,0,1,1.55-7.5c1.26-.84,3.49-2.47,4.74-3.1a2.4,2.4,0,0,1,3.31.73l0,.06a5.61,5.61,0,0,0,3.46,2.46,5.36,5.36,0,0,0,4-.67l.25-.16a5.37,5.37,0,0,0,2.31-3.46,5.6,5.6,0,0,0-.86-4.15l-.09-.15a2.4,2.4,0,0,1,.79-3.29l5.95-3.65a2.39,2.39,0,0,1,3.32.69,5.45,5.45,0,0,0,7.57,1.59l.06,0a5.5,5.5,0,0,0,2.32-3.43,5.34,5.34,0,0,0-.76-4l-.15-.22a2.4,2.4,0,0,1,.7-3.32l4-2.62a5.45,5.45,0,0,1,7.52,1.58C80,19,85.73,28,91.11,36.26c4,6.26,7.83,12.11,15.49,23.83h.63a5.46,5.46,0,0,1,5.45,5.44v5.61a2.41,2.41,0,0,1-2.4,2.4H110a5.3,5.3,0,0,0-3.77,1.57,5.47,5.47,0,0,0-1.61,3.83v.14a5.32,5.32,0,0,0,1.62,3.84l.11.11a5.63,5.63,0,0,0,3.84,1.45h.1a2.4,2.4,0,0,1,2.4,2.38h0v10a2.4,2.4,0,0,1-2.4,2.4h-.1a5.7,5.7,0,0,0-3.94,1.55,5.37,5.37,0,0,0-1.64,3.84v.15a5.49,5.49,0,0,0,1.61,3.83,5.32,5.32,0,0,0,3.77,1.58h.28a2.39,2.39,0,0,1,2.41,2.37v0h0v4.78a5.46,5.46,0,0,1-5.45,5.44H5.44A5.46,5.46,0,0,1,0,117.44v-4.78a2.4,2.4,0,0,1,2.4-2.4h.3a5.3,5.3,0,0,0,3.77-1.57,5.55,5.55,0,0,0,1.61-3.83v-.07h0A5.46,5.46,0,0,0,2.6,99.32a2.4,2.4,0,0,1-2.4-2.4v-.16L0,86.92a2.39,2.39,0,0,1,2.34-2.44H2.5a5.67,5.67,0,0,0,4-1.54h0a5.36,5.36,0,0,0,1.62-3.84v-.16a5.37,5.37,0,0,0-1.62-3.83L6.35,75A5.68,5.68,0,0,0,2.5,73.54l-.27,0A2.38,2.38,0,0,1,0,71.15H0V65.53a5.46,5.46,0,0,1,5.44-5.44Zm26.09,45.22a3.74,3.74,0,0,1-1.49,1.46,6.91,6.91,0,0,1-3.15.52c-1.48,0-2.21-.39-2.21-1.17a1.47,1.47,0,0,1,.09-.36l16-28.23a6.19,6.19,0,0,1,.75-1.11,3.53,3.53,0,0,1,1.24-.77,5.87,5.87,0,0,1,2.25-.38c1.87,0,2.8.41,2.8,1.22a.87.87,0,0,1-.09.4L61.28,105.31ZM54,92.45a14.65,14.65,0,0,1-3.46-.36,7.93,7.93,0,0,1-2.72-1.26c-1.72-1.23-2.57-3.62-2.57-7.17s.9-5.77,2.7-7a11,11,0,0,1,6-1.48,11.34,11.34,0,0,1,6.08,1.48c1.81,1.18,2.71,3.49,2.71,7s-.86,6-2.57,7.17A10.75,10.75,0,0,1,54,92.45Zm0-4.37a.72.72,0,0,0,.58-.27c.39-.42.59-1.49.59-3.2A22.78,22.78,0,0,0,55,81.07a2.65,2.65,0,0,0-.41-1.2.78.78,0,0,0-.58-.22c-.79,0-1.18,1.4-1.18,4.21s.39,4.22,1.18,4.22ZM77.7,107.74a14.5,14.5,0,0,1-3.45-.36,7.89,7.89,0,0,1-2.73-1.26C69.8,104.89,69,102.5,69,99s.9-5.76,2.7-6.9a10.76,10.76,0,0,1,6-1.54,11.14,11.14,0,0,1,6.09,1.54q2.7,1.71,2.7,6.9c0,3.58-.85,6-2.57,7.17a10.75,10.75,0,0,1-6.22,1.62Zm0-4.37a.78.78,0,0,0,.58-.23c.4-.45.59-1.53.59-3.24a22.78,22.78,0,0,0-.18-3.54,2.65,2.65,0,0,0-.41-1.2.78.78,0,0,0-.58-.23c-.78,0-1.17,1.41-1.17,4.22s.39,4.22,1.17,4.22Zm29.53-38.48h-78v3.6a1.63,1.63,0,0,1,0,.31A2.1,2.1,0,0,1,25,68.49v-3.6H5.44a.64.64,0,0,0-.45.19.68.68,0,0,0-.19.45V69a10.38,10.38,0,0,1,4.83,2.53l.15.13a10.14,10.14,0,0,1,3.08,7.25v.24a10.14,10.14,0,0,1-3.08,7.24A10.36,10.36,0,0,1,4.84,89L5,94.79a10.26,10.26,0,0,1,7.92,10s0,.1,0,.12a10.28,10.28,0,0,1-8.06,9.93v2.6a.65.65,0,0,0,.64.64H25V114.7a1.45,1.45,0,0,1,0-.3,2.1,2.1,0,0,1,4.18.3v3.38h78a.67.67,0,0,0,.65-.64v-2.61a10.13,10.13,0,0,1-5.07-2.77,10.33,10.33,0,0,1-3-7.15v-.24a10.18,10.18,0,0,1,3.09-7.23h0a10.38,10.38,0,0,1,5-2.66V89a10.27,10.27,0,0,1-4.83-2.52l-.15-.13a10.19,10.19,0,0,1-3.09-7.24v-.25a10.37,10.37,0,0,1,3-7.15A10.14,10.14,0,0,1,107.88,69V65.53a.65.65,0,0,0-.2-.45.6.6,0,0,0-.45-.19ZM25,81.09a2.1,2.1,0,0,0,4.18.31,1.55,1.55,0,0,0,0-.31v-4.2a2.1,2.1,0,0,0-4.18-.3,1.45,1.45,0,0,0,0,.3v4.2ZM25,93.7a2.1,2.1,0,0,0,4.18.3,1.45,1.45,0,0,0,0-.3V89.5a2.1,2.1,0,0,0-4.18-.31,1.55,1.55,0,0,0,0,.31v4.2Zm0,12.6a2.1,2.1,0,0,0,4.18.31,1.63,1.63,0,0,0,0-.31v-4.2a2.1,2.1,0,0,0-4.18-.31,1.63,1.63,0,0,0,0,.31v4.2ZM55.75,43a2.76,2.76,0,0,0,1.08-1.39,2.7,2.7,0,0,0-4-3.13l-4.52,3a2.7,2.7,0,1,0,3,4.52l4.52-3Zm13.56-8.87a2.62,2.62,0,0,0,1.08-1.39,2.7,2.7,0,0,0-4-3.13l-4.53,3A2.76,2.76,0,0,0,60.75,34a2.7,2.7,0,0,0,4,3.13l4.52-3Z"/></svg>
                                <span class="side-menu__label">Subscription Plans</span>
                            </a>
                        </li>
                        <?php
                        $subscriptionActive = '';
                        $openClass = '';
                        $submenuActive = '';

                        $routes = ['freetrialuser', 'freeuser', 'subscribedusers', 'unsubscribedusers'];

                        if (in_array($current_route, $routes)) {
                            $subscriptionActive = 'active';
                            $openClass = 'open';
                        }

                        if ($current_route == 'freetrialuser') {
                            $submenuActive = 'freetrialuser';
                        } elseif ($current_route == 'freeuser') {
                            $submenuActive = 'freeuser';
                        } elseif ($current_route == 'subscribedusers') {
                            $submenuActive = 'subscribedusers';
                        } elseif ($current_route == 'unsubscribedusers') {
                            $submenuActive = 'unsubscribedusers';
                        }
                        ?>
                        <li class="slide has-sub {{$subscriptionActive}} {{$openClass}}">
                            <a href="javascript:void(0);" class="side-menu__item {{$subscriptionActive}}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></svg>
                                <span class="side-menu__label">User Subscription</span>
                                <i class="fe fe-chevron-down side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1 mega-menu">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">User Subscription</a>
                                </li>
                                <li class="slide">
                                    <!--<a href="{{route('freetrialuser')}}" class="side-menu__item {{$submenuActive == 'freetrialuser' ? 'active' : ''}}">Free Trial Users</a>-->
                                    <a href="{{route('freeuser')}}" class="side-menu__item {{$submenuActive == 'freeuser' ? 'active' : ''}}">Free Users</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('freetrialuser')}}" class="side-menu__item {{$submenuActive == 'freetrialuser' ? 'active' : ''}}">Free Trial Users</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('subscribedusers')}}" class="side-menu__item {{$submenuActive == 'subscribedusers' ? 'active' : ''}}">Subscribed Users</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('unsubscribedusers')}}" class="side-menu__item {{$submenuActive == 'unsubscribedusers' ? 'active' : ''}}">Unsubscribed Users</a>
                                </li>
                            </ul>
                        </li>
                        
                        <?php
                        $news = '';
                        if ($current_route == 'news' 
                                || $current_route == 'addnews' 
                                || $current_route == 'editnews') {
                            $news = 'active';
                        }
                        ?>
                        <li class="slide {{ $news }}">
                            <a href="{{route('news')}}" class="side-menu__item {{ $news }} ">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 50 50">
                                <path d="M 1.71875 2.78125 C 1.253906 2.886719 0.925781 3.304688 0.9375 3.78125 L 0.9375 39.46875 C 0.9375 43.714844 3.144531 46.109375 5.3125 47.1875 C 7.480469 48.265625 9.625 48.21875 9.625 48.21875 L 40.375 48.21875 L 40.375 48.125 C 40.855469 48.179688 41.375 48.21875 41.375 48.21875 C 41.375 48.21875 43.296875 48.230469 45.21875 47.125 C 47.09375 46.046875 48.941406 43.765625 49.03125 39.8125 C 49.042969 39.792969 49.054688 39.769531 49.0625 39.75 C 49.0625 39.726563 49.0625 39.710938 49.0625 39.6875 C 49.066406 39.636719 49.066406 39.582031 49.0625 39.53125 L 49.0625 14.4375 C 49.0625 14.425781 49.0625 14.417969 49.0625 14.40625 C 49.0625 14.40625 49.078125 13.234375 48.46875 12.03125 C 47.859375 10.828125 46.441406 9.53125 44.21875 9.53125 L 44.21875 9.5 L 34.75 9.5 L 34.75 11.5 L 40.3125 11.5 C 40.191406 11.671875 40.089844 11.828125 40 12 C 39.390625 13.191406 39.375 14.375 39.375 14.375 L 39.375 38.625 C 39.371094 38.984375 39.558594 39.320313 39.871094 39.503906 C 40.183594 39.683594 40.566406 39.683594 40.878906 39.503906 C 41.191406 39.320313 41.378906 38.984375 41.375 38.625 L 41.375 14.375 C 41.375 14.347656 41.414063 13.625 41.78125 12.90625 C 42.15625 12.175781 42.683594 11.53125 44.21875 11.53125 C 45.75 11.53125 46.277344 12.191406 46.65625 12.9375 C 47.027344 13.671875 47.09375 14.410156 47.09375 14.4375 L 47.0625 14.4375 L 47.0625 39.53125 C 47.0625 43.089844 45.640625 44.589844 44.21875 45.40625 C 42.796875 46.222656 41.375 46.21875 41.375 46.21875 C 41.375 46.21875 39.683594 46.195313 38 45.34375 C 36.316406 44.492188 34.6875 42.996094 34.6875 39.46875 L 34.6875 3.78125 C 34.6875 3.230469 34.238281 2.78125 33.6875 2.78125 L 1.9375 2.78125 C 1.863281 2.773438 1.792969 2.773438 1.71875 2.78125 Z M 2.9375 4.78125 L 32.6875 4.78125 L 32.6875 39.46875 C 32.6875 42.757813 34.082031 44.910156 35.71875 46.21875 L 9.625 46.21875 C 9.613281 46.21875 9.605469 46.21875 9.59375 46.21875 C 9.59375 46.21875 9.164063 46.222656 8.53125 46.125 C 8.214844 46.074219 7.863281 45.992188 7.46875 45.875 C 7.074219 45.757813 6.636719 45.613281 6.21875 45.40625 C 6.007813 45.300781 5.796875 45.191406 5.59375 45.0625 C 4.164063 44.164063 2.9375 42.613281 2.9375 39.46875 Z M 6.9375 11 C 6.386719 11.078125 6 11.589844 6.078125 12.140625 C 6.15625 12.691406 6.667969 13.078125 7.21875 13 L 26.9375 13 C 27.296875 13.003906 27.632813 12.816406 27.816406 12.503906 C 27.996094 12.191406 27.996094 11.808594 27.816406 11.496094 C 27.632813 11.183594 27.296875 10.996094 26.9375 11 L 7.21875 11 C 7.1875 11 7.15625 11 7.125 11 C 7.09375 11 7.0625 11 7.03125 11 C 7 11 6.96875 11 6.9375 11 Z M 6.9375 15 C 6.386719 15.078125 6 15.589844 6.078125 16.140625 C 6.15625 16.691406 6.667969 17.078125 7.21875 17 L 26.9375 17 C 27.296875 17.003906 27.632813 16.816406 27.816406 16.503906 C 27.996094 16.191406 27.996094 15.808594 27.816406 15.496094 C 27.632813 15.183594 27.296875 14.996094 26.9375 15 L 7.21875 15 C 7.1875 15 7.15625 15 7.125 15 C 7.09375 15 7.0625 15 7.03125 15 C 7 15 6.96875 15 6.9375 15 Z M 7.40625 23 C 6.855469 23.078125 6.46875 23.589844 6.546875 24.140625 C 6.625 24.691406 7.136719 25.078125 7.6875 25 L 14.46875 25 C 14.828125 25.003906 15.164063 24.816406 15.347656 24.503906 C 15.527344 24.191406 15.527344 23.808594 15.347656 23.496094 C 15.164063 23.183594 14.828125 22.996094 14.46875 23 L 7.6875 23 C 7.65625 23 7.625 23 7.59375 23 C 7.5625 23 7.53125 23 7.5 23 C 7.46875 23 7.4375 23 7.40625 23 Z M 18.9375 23 C 18.386719 23.078125 18 23.589844 18.078125 24.140625 C 18.15625 24.691406 18.667969 25.078125 19.21875 25 L 26.9375 25 C 27.296875 25.003906 27.632813 24.816406 27.816406 24.503906 C 27.996094 24.191406 27.996094 23.808594 27.816406 23.496094 C 27.632813 23.183594 27.296875 22.996094 26.9375 23 L 19.21875 23 C 19.1875 23 19.15625 23 19.125 23 C 19.09375 23 19.0625 23 19.03125 23 C 19 23 18.96875 23 18.9375 23 Z M 7.40625 27 C 6.855469 27.078125 6.46875 27.589844 6.546875 28.140625 C 6.625 28.691406 7.136719 29.078125 7.6875 29 L 14.46875 29 C 14.828125 29.003906 15.164063 28.816406 15.347656 28.503906 C 15.527344 28.191406 15.527344 27.808594 15.347656 27.496094 C 15.164063 27.183594 14.828125 26.996094 14.46875 27 L 7.6875 27 C 7.65625 27 7.625 27 7.59375 27 C 7.5625 27 7.53125 27 7.5 27 C 7.46875 27 7.4375 27 7.40625 27 Z M 18.9375 27 C 18.386719 27.078125 18 27.589844 18.078125 28.140625 C 18.15625 28.691406 18.667969 29.078125 19.21875 29 L 26.9375 29 C 27.296875 29.003906 27.632813 28.816406 27.816406 28.503906 C 27.996094 28.191406 27.996094 27.808594 27.816406 27.496094 C 27.632813 27.183594 27.296875 26.996094 26.9375 27 L 19.21875 27 C 19.1875 27 19.15625 27 19.125 27 C 19.09375 27 19.0625 27 19.03125 27 C 19 27 18.96875 27 18.9375 27 Z M 18.9375 30.78125 C 18.386719 30.859375 18 31.371094 18.078125 31.921875 C 18.15625 32.472656 18.667969 32.859375 19.21875 32.78125 L 26.9375 32.78125 C 27.296875 32.785156 27.632813 32.597656 27.816406 32.285156 C 27.996094 31.972656 27.996094 31.589844 27.816406 31.277344 C 27.632813 30.964844 27.296875 30.777344 26.9375 30.78125 L 19.21875 30.78125 C 19.15625 30.773438 19.09375 30.773438 19.03125 30.78125 C 19 30.78125 18.96875 30.78125 18.9375 30.78125 Z M 7.40625 31 C 6.855469 31.078125 6.46875 31.589844 6.546875 32.140625 C 6.625 32.691406 7.136719 33.078125 7.6875 33 L 14.46875 33 C 14.828125 33.003906 15.164063 32.816406 15.347656 32.503906 C 15.527344 32.191406 15.527344 31.808594 15.347656 31.496094 C 15.164063 31.183594 14.828125 30.996094 14.46875 31 L 7.6875 31 C 7.65625 31 7.625 31 7.59375 31 C 7.5625 31 7.53125 31 7.5 31 C 7.46875 31 7.4375 31 7.40625 31 Z M 18.9375 34.78125 C 18.386719 34.859375 18 35.371094 18.078125 35.921875 C 18.15625 36.472656 18.667969 36.859375 19.21875 36.78125 L 26.9375 36.78125 C 27.296875 36.785156 27.632813 36.597656 27.816406 36.285156 C 27.996094 35.972656 27.996094 35.589844 27.816406 35.277344 C 27.632813 34.964844 27.296875 34.777344 26.9375 34.78125 L 19.21875 34.78125 C 19.15625 34.773438 19.09375 34.773438 19.03125 34.78125 C 19 34.78125 18.96875 34.78125 18.9375 34.78125 Z M 7.40625 35 C 6.855469 35.078125 6.46875 35.589844 6.546875 36.140625 C 6.625 36.691406 7.136719 37.078125 7.6875 37 L 14.46875 37 C 14.828125 37.003906 15.164063 36.816406 15.347656 36.503906 C 15.527344 36.191406 15.527344 35.808594 15.347656 35.496094 C 15.164063 35.183594 14.828125 34.996094 14.46875 35 L 7.6875 35 C 7.65625 35 7.625 35 7.59375 35 C 7.5625 35 7.53125 35 7.5 35 C 7.46875 35 7.4375 35 7.40625 35 Z M 18.9375 38.53125 C 18.386719 38.609375 18 39.121094 18.078125 39.671875 C 18.15625 40.222656 18.667969 40.609375 19.21875 40.53125 L 26.9375 40.53125 C 27.296875 40.535156 27.632813 40.347656 27.816406 40.035156 C 27.996094 39.722656 27.996094 39.339844 27.816406 39.027344 C 27.632813 38.714844 27.296875 38.527344 26.9375 38.53125 L 19.21875 38.53125 C 19.1875 38.53125 19.15625 38.53125 19.125 38.53125 C 19.09375 38.53125 19.0625 38.53125 19.03125 38.53125 C 19 38.53125 18.96875 38.53125 18.9375 38.53125 Z M 7.40625 39 C 6.855469 39.078125 6.46875 39.589844 6.546875 40.140625 C 6.625 40.691406 7.136719 41.078125 7.6875 41 L 14.46875 41 C 14.828125 41.003906 15.164063 40.816406 15.347656 40.503906 C 15.527344 40.191406 15.527344 39.808594 15.347656 39.496094 C 15.164063 39.183594 14.828125 38.996094 14.46875 39 L 7.6875 39 C 7.65625 39 7.625 39 7.59375 39 C 7.5625 39 7.53125 39 7.5 39 C 7.46875 39 7.4375 39 7.40625 39 Z"></path>
                                </svg>
                                <span class="side-menu__label">News Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $blog = '';
                        if ($current_route == 'blog' 
                                || $current_route == 'addblog' 
                                || $current_route == 'editblog') {
                            $blog = 'active';
                        }
                        ?>
                        <li class="slide {{ $blog }}">
                            <a href="{{route('blog')}}" class="side-menu__item {{ $blog }} ">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 50 50">
                                <path d="M 1.71875 2.78125 C 1.253906 2.886719 0.925781 3.304688 0.9375 3.78125 L 0.9375 39.46875 C 0.9375 43.714844 3.144531 46.109375 5.3125 47.1875 C 7.480469 48.265625 9.625 48.21875 9.625 48.21875 L 40.375 48.21875 L 40.375 48.125 C 40.855469 48.179688 41.375 48.21875 41.375 48.21875 C 41.375 48.21875 43.296875 48.230469 45.21875 47.125 C 47.09375 46.046875 48.941406 43.765625 49.03125 39.8125 C 49.042969 39.792969 49.054688 39.769531 49.0625 39.75 C 49.0625 39.726563 49.0625 39.710938 49.0625 39.6875 C 49.066406 39.636719 49.066406 39.582031 49.0625 39.53125 L 49.0625 14.4375 C 49.0625 14.425781 49.0625 14.417969 49.0625 14.40625 C 49.0625 14.40625 49.078125 13.234375 48.46875 12.03125 C 47.859375 10.828125 46.441406 9.53125 44.21875 9.53125 L 44.21875 9.5 L 34.75 9.5 L 34.75 11.5 L 40.3125 11.5 C 40.191406 11.671875 40.089844 11.828125 40 12 C 39.390625 13.191406 39.375 14.375 39.375 14.375 L 39.375 38.625 C 39.371094 38.984375 39.558594 39.320313 39.871094 39.503906 C 40.183594 39.683594 40.566406 39.683594 40.878906 39.503906 C 41.191406 39.320313 41.378906 38.984375 41.375 38.625 L 41.375 14.375 C 41.375 14.347656 41.414063 13.625 41.78125 12.90625 C 42.15625 12.175781 42.683594 11.53125 44.21875 11.53125 C 45.75 11.53125 46.277344 12.191406 46.65625 12.9375 C 47.027344 13.671875 47.09375 14.410156 47.09375 14.4375 L 47.0625 14.4375 L 47.0625 39.53125 C 47.0625 43.089844 45.640625 44.589844 44.21875 45.40625 C 42.796875 46.222656 41.375 46.21875 41.375 46.21875 C 41.375 46.21875 39.683594 46.195313 38 45.34375 C 36.316406 44.492188 34.6875 42.996094 34.6875 39.46875 L 34.6875 3.78125 C 34.6875 3.230469 34.238281 2.78125 33.6875 2.78125 L 1.9375 2.78125 C 1.863281 2.773438 1.792969 2.773438 1.71875 2.78125 Z M 2.9375 4.78125 L 32.6875 4.78125 L 32.6875 39.46875 C 32.6875 42.757813 34.082031 44.910156 35.71875 46.21875 L 9.625 46.21875 C 9.613281 46.21875 9.605469 46.21875 9.59375 46.21875 C 9.59375 46.21875 9.164063 46.222656 8.53125 46.125 C 8.214844 46.074219 7.863281 45.992188 7.46875 45.875 C 7.074219 45.757813 6.636719 45.613281 6.21875 45.40625 C 6.007813 45.300781 5.796875 45.191406 5.59375 45.0625 C 4.164063 44.164063 2.9375 42.613281 2.9375 39.46875 Z M 6.9375 11 C 6.386719 11.078125 6 11.589844 6.078125 12.140625 C 6.15625 12.691406 6.667969 13.078125 7.21875 13 L 26.9375 13 C 27.296875 13.003906 27.632813 12.816406 27.816406 12.503906 C 27.996094 12.191406 27.996094 11.808594 27.816406 11.496094 C 27.632813 11.183594 27.296875 10.996094 26.9375 11 L 7.21875 11 C 7.1875 11 7.15625 11 7.125 11 C 7.09375 11 7.0625 11 7.03125 11 C 7 11 6.96875 11 6.9375 11 Z M 6.9375 15 C 6.386719 15.078125 6 15.589844 6.078125 16.140625 C 6.15625 16.691406 6.667969 17.078125 7.21875 17 L 26.9375 17 C 27.296875 17.003906 27.632813 16.816406 27.816406 16.503906 C 27.996094 16.191406 27.996094 15.808594 27.816406 15.496094 C 27.632813 15.183594 27.296875 14.996094 26.9375 15 L 7.21875 15 C 7.1875 15 7.15625 15 7.125 15 C 7.09375 15 7.0625 15 7.03125 15 C 7 15 6.96875 15 6.9375 15 Z M 7.40625 23 C 6.855469 23.078125 6.46875 23.589844 6.546875 24.140625 C 6.625 24.691406 7.136719 25.078125 7.6875 25 L 14.46875 25 C 14.828125 25.003906 15.164063 24.816406 15.347656 24.503906 C 15.527344 24.191406 15.527344 23.808594 15.347656 23.496094 C 15.164063 23.183594 14.828125 22.996094 14.46875 23 L 7.6875 23 C 7.65625 23 7.625 23 7.59375 23 C 7.5625 23 7.53125 23 7.5 23 C 7.46875 23 7.4375 23 7.40625 23 Z M 18.9375 23 C 18.386719 23.078125 18 23.589844 18.078125 24.140625 C 18.15625 24.691406 18.667969 25.078125 19.21875 25 L 26.9375 25 C 27.296875 25.003906 27.632813 24.816406 27.816406 24.503906 C 27.996094 24.191406 27.996094 23.808594 27.816406 23.496094 C 27.632813 23.183594 27.296875 22.996094 26.9375 23 L 19.21875 23 C 19.1875 23 19.15625 23 19.125 23 C 19.09375 23 19.0625 23 19.03125 23 C 19 23 18.96875 23 18.9375 23 Z M 7.40625 27 C 6.855469 27.078125 6.46875 27.589844 6.546875 28.140625 C 6.625 28.691406 7.136719 29.078125 7.6875 29 L 14.46875 29 C 14.828125 29.003906 15.164063 28.816406 15.347656 28.503906 C 15.527344 28.191406 15.527344 27.808594 15.347656 27.496094 C 15.164063 27.183594 14.828125 26.996094 14.46875 27 L 7.6875 27 C 7.65625 27 7.625 27 7.59375 27 C 7.5625 27 7.53125 27 7.5 27 C 7.46875 27 7.4375 27 7.40625 27 Z M 18.9375 27 C 18.386719 27.078125 18 27.589844 18.078125 28.140625 C 18.15625 28.691406 18.667969 29.078125 19.21875 29 L 26.9375 29 C 27.296875 29.003906 27.632813 28.816406 27.816406 28.503906 C 27.996094 28.191406 27.996094 27.808594 27.816406 27.496094 C 27.632813 27.183594 27.296875 26.996094 26.9375 27 L 19.21875 27 C 19.1875 27 19.15625 27 19.125 27 C 19.09375 27 19.0625 27 19.03125 27 C 19 27 18.96875 27 18.9375 27 Z M 18.9375 30.78125 C 18.386719 30.859375 18 31.371094 18.078125 31.921875 C 18.15625 32.472656 18.667969 32.859375 19.21875 32.78125 L 26.9375 32.78125 C 27.296875 32.785156 27.632813 32.597656 27.816406 32.285156 C 27.996094 31.972656 27.996094 31.589844 27.816406 31.277344 C 27.632813 30.964844 27.296875 30.777344 26.9375 30.78125 L 19.21875 30.78125 C 19.15625 30.773438 19.09375 30.773438 19.03125 30.78125 C 19 30.78125 18.96875 30.78125 18.9375 30.78125 Z M 7.40625 31 C 6.855469 31.078125 6.46875 31.589844 6.546875 32.140625 C 6.625 32.691406 7.136719 33.078125 7.6875 33 L 14.46875 33 C 14.828125 33.003906 15.164063 32.816406 15.347656 32.503906 C 15.527344 32.191406 15.527344 31.808594 15.347656 31.496094 C 15.164063 31.183594 14.828125 30.996094 14.46875 31 L 7.6875 31 C 7.65625 31 7.625 31 7.59375 31 C 7.5625 31 7.53125 31 7.5 31 C 7.46875 31 7.4375 31 7.40625 31 Z M 18.9375 34.78125 C 18.386719 34.859375 18 35.371094 18.078125 35.921875 C 18.15625 36.472656 18.667969 36.859375 19.21875 36.78125 L 26.9375 36.78125 C 27.296875 36.785156 27.632813 36.597656 27.816406 36.285156 C 27.996094 35.972656 27.996094 35.589844 27.816406 35.277344 C 27.632813 34.964844 27.296875 34.777344 26.9375 34.78125 L 19.21875 34.78125 C 19.15625 34.773438 19.09375 34.773438 19.03125 34.78125 C 19 34.78125 18.96875 34.78125 18.9375 34.78125 Z M 7.40625 35 C 6.855469 35.078125 6.46875 35.589844 6.546875 36.140625 C 6.625 36.691406 7.136719 37.078125 7.6875 37 L 14.46875 37 C 14.828125 37.003906 15.164063 36.816406 15.347656 36.503906 C 15.527344 36.191406 15.527344 35.808594 15.347656 35.496094 C 15.164063 35.183594 14.828125 34.996094 14.46875 35 L 7.6875 35 C 7.65625 35 7.625 35 7.59375 35 C 7.5625 35 7.53125 35 7.5 35 C 7.46875 35 7.4375 35 7.40625 35 Z M 18.9375 38.53125 C 18.386719 38.609375 18 39.121094 18.078125 39.671875 C 18.15625 40.222656 18.667969 40.609375 19.21875 40.53125 L 26.9375 40.53125 C 27.296875 40.535156 27.632813 40.347656 27.816406 40.035156 C 27.996094 39.722656 27.996094 39.339844 27.816406 39.027344 C 27.632813 38.714844 27.296875 38.527344 26.9375 38.53125 L 19.21875 38.53125 C 19.1875 38.53125 19.15625 38.53125 19.125 38.53125 C 19.09375 38.53125 19.0625 38.53125 19.03125 38.53125 C 19 38.53125 18.96875 38.53125 18.9375 38.53125 Z M 7.40625 39 C 6.855469 39.078125 6.46875 39.589844 6.546875 40.140625 C 6.625 40.691406 7.136719 41.078125 7.6875 41 L 14.46875 41 C 14.828125 41.003906 15.164063 40.816406 15.347656 40.503906 C 15.527344 40.191406 15.527344 39.808594 15.347656 39.496094 C 15.164063 39.183594 14.828125 38.996094 14.46875 39 L 7.6875 39 C 7.65625 39 7.625 39 7.59375 39 C 7.5625 39 7.53125 39 7.5 39 C 7.46875 39 7.4375 39 7.40625 39 Z"></path>
                                </svg>
                                <span class="side-menu__label">Blog Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $advertisement = '';
                        if ($current_route == 'advertisement' 
                                || $current_route == 'addadvertisement' 
                                || $current_route == 'editadvertisement'
                                || $current_route == 'adschart'
                                || $current_route == 'adsanalysisreport') {
                            $advertisement = 'active';
                        }
                        ?>
                        <li class="slide {{ $advertisement }}">
                            <a href="{{route('advertisement')}}" class="side-menu__item {{ $advertisement }} ">
                                <svg class="side-menu__icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490 490" xml:space="preserve"><g><g><polygon style="fill:#D7DCDD;" points="425,10 425,440 375,440 375,60 110,60 110,10 "/></g><path d="M425,0H110c-5.523,0-10,4.478-10,10v40H65c-5.523,0-10,4.478-10,10v420c0,5.522,4.477,10,10,10h310c5.522,0,10-4.478,10-10v-30h40c5.522,0,10-4.478,10-10V10C435,4.478,430.522,0,425,0z M365,470H75V70h50v190 c0,7.271,5.257,15,15,15h75c0.415,0,0.829-0.025,1.24-0.077C223.078,274.068,230,268.668,230,260V105 c0-0.208-0.006-0.415-0.02-0.623C229.545,97.407,224.147,90,215,90c0,0-40.829,0.025-41.24,0.077 C166.922,90.932,160,96.332,160,105v135h20V110h30v145h-65V70h220V470z M415,430h-30V60c0-5.522-4.478-10-10-10H120V20h295V430z"/><g><rect x="270" y="125"  width="70" height="20"/></g><g><rect x="250" y="165"  width="90" height="20"/></g><g><rect x="250" y="205"  width="90" height="20"/></g><g><rect x="250" y="245"  width="90" height="20"/></g><g><rect x="100" y="295"  width="240" height="20"/></g><g><rect x="100" y="335"  width="240" height="20"/></g><g><rect x="100" y="375"  width="240" height="20"/></g><g><rect x="100" y="415"  width="200" height="20"/></g><g><rect x="320" y="415"  width="20" height="20"/></g></g></svg>
                                <span class="side-menu__label">Ads Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $reportActive = '';
                        $fopenClass = '';
                        $fsubmenuActive = '';

                        $routes = ['orderreport','vieworderreport', 'interactionreport','viewinteractionreport', 'contestreport','viewcontestreport', 'questionreport','viewquestionreport', 'transaction', 'booking', 'quizreport', 'viewquizreport'];

                        if (in_array($current_route, $routes)) {
                            $reportActive = 'active';
                            $fopenClass = 'open';
                        }

                        if ($current_route == 'orderreport' || $current_route == 'vieworderreport') {
                            $fsubmenuActive = 'orderreport';
                        } elseif ($current_route == 'interactionreport' || $current_route == 'viewinteractionreport') {
                            $fsubmenuActive = 'interactionreport';
                        } elseif ($current_route == 'contestreport' || $current_route == 'viewcontestreport') {
                            $fsubmenuActive = 'contestreport';
                        } elseif ($current_route == 'questionreport' || $current_route == 'viewquestionreport') {
                            $fsubmenuActive = 'questionreport';
                        } elseif ($current_route == 'transaction') {
                            $fsubmenuActive = 'transaction';
                        } elseif ($current_route == 'booking') {
                            $fsubmenuActive = 'booking';
                        } elseif ($current_route == 'quizreport' || $current_route == 'viewquizreport') {
                            $fsubmenuActive = 'quizreport';
                        }
                        ?>

                        <li class="slide has-sub {{$reportActive}} {{$fopenClass}}">
                            <a href="javascript:void(0);" class="side-menu__item {{$reportActive}}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></svg>
                                <span class="side-menu__label">FPL Reports</span>
                                <i class="fe fe-chevron-down side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1 mega-menu">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">FPL Reports</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('orderreport')}}" class="side-menu__item {{$fsubmenuActive == 'orderreport' ? 'active' : ''}}">Order Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('transaction')}}" class="side-menu__item {{$fsubmenuActive == 'transaction' ? 'active' : ''}}">Subscription Transaction Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('booking')}}" class="side-menu__item {{$fsubmenuActive == 'booking' ? 'active' : ''}}">Booking Request Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('interactionreport')}}" class="side-menu__item {{$fsubmenuActive == 'interactionreport' ? 'active' : ''}}">Interaction Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('contestreport')}}" class="side-menu__item {{$fsubmenuActive == 'contestreport' ? 'active' : ''}}">Contest Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('questionreport')}}" class="side-menu__item {{$fsubmenuActive == 'questionreport' ? 'active' : ''}}">Question & Answer Report</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('quizreport')}}" class="side-menu__item {{$fsubmenuActive == 'quizreport' ? 'active' : ''}}">Quiz Report</a>
                                </li>
                            </ul>
                        </li>

                        <?php
                        $coupon = '';
                        if ($current_route == 'coupon' 
                                || $current_route == 'addcoupon' 
                                || $current_route == 'editcoupon') {
                            $coupon = 'active';
                        }
                        ?>
                        <li class="slide {{ $coupon }}">
                            <a href="{{route('coupon')}}" class="side-menu__item {{ $coupon }} ">
                                <svg class="side-menu__icon" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 112.68 122.88"><title>discount-voucher</title><path d="M100.87,60.09c-5.65-8.65-9.59-14.76-13.78-21.23-2.2-3.41-4.48-6.93-7.44-11.48l-1.3.85a2.7,2.7,0,0,1-4-3.12,2.64,2.64,0,0,1,1.08-1.4l1.31-.86c-3-4.68-6.77-10.39-11.59-17.77a.68.68,0,0,0-.41-.28.71.71,0,0,0-.49.09L62,6.32a10.12,10.12,0,0,1,.45,5.75,10.24,10.24,0,0,1-4.36,6.44l-.07.06A10.31,10.31,0,0,1,45.34,17.4L43,18.86a10.3,10.3,0,0,1,.48,5.56A10.13,10.13,0,0,1,39.09,31l-.37.24a10.09,10.09,0,0,1-7.58,1.28,10.39,10.39,0,0,1-5-2.71l-2.93,1.91a.65.65,0,0,0-.24.38.68.68,0,0,0,0,.42l.1.16c4.7,7.19,8.39,12.93,11.47,17.72l.08,0,4.52-3a2.7,2.7,0,0,1,4,3.12,2.74,2.74,0,0,1-1.08,1.4l-4.52,2.95-.12.07c1.13,1.77,2.22,3.46,3.35,5.19Zm-65.68,0-3.85-6c-3.1-4.83-6.85-10.67-12.25-18.94h0a5.43,5.43,0,0,1,1.55-7.5c1.26-.84,3.49-2.47,4.74-3.1a2.4,2.4,0,0,1,3.31.73l0,.06a5.61,5.61,0,0,0,3.46,2.46,5.36,5.36,0,0,0,4-.67l.25-.16a5.37,5.37,0,0,0,2.31-3.46,5.6,5.6,0,0,0-.86-4.15l-.09-.15a2.4,2.4,0,0,1,.79-3.29l5.95-3.65a2.39,2.39,0,0,1,3.32.69,5.45,5.45,0,0,0,7.57,1.59l.06,0a5.5,5.5,0,0,0,2.32-3.43,5.34,5.34,0,0,0-.76-4l-.15-.22a2.4,2.4,0,0,1,.7-3.32l4-2.62a5.45,5.45,0,0,1,7.52,1.58C80,19,85.73,28,91.11,36.26c4,6.26,7.83,12.11,15.49,23.83h.63a5.46,5.46,0,0,1,5.45,5.44v5.61a2.41,2.41,0,0,1-2.4,2.4H110a5.3,5.3,0,0,0-3.77,1.57,5.47,5.47,0,0,0-1.61,3.83v.14a5.32,5.32,0,0,0,1.62,3.84l.11.11a5.63,5.63,0,0,0,3.84,1.45h.1a2.4,2.4,0,0,1,2.4,2.38h0v10a2.4,2.4,0,0,1-2.4,2.4h-.1a5.7,5.7,0,0,0-3.94,1.55,5.37,5.37,0,0,0-1.64,3.84v.15a5.49,5.49,0,0,0,1.61,3.83,5.32,5.32,0,0,0,3.77,1.58h.28a2.39,2.39,0,0,1,2.41,2.37v0h0v4.78a5.46,5.46,0,0,1-5.45,5.44H5.44A5.46,5.46,0,0,1,0,117.44v-4.78a2.4,2.4,0,0,1,2.4-2.4h.3a5.3,5.3,0,0,0,3.77-1.57,5.55,5.55,0,0,0,1.61-3.83v-.07h0A5.46,5.46,0,0,0,2.6,99.32a2.4,2.4,0,0,1-2.4-2.4v-.16L0,86.92a2.39,2.39,0,0,1,2.34-2.44H2.5a5.67,5.67,0,0,0,4-1.54h0a5.36,5.36,0,0,0,1.62-3.84v-.16a5.37,5.37,0,0,0-1.62-3.83L6.35,75A5.68,5.68,0,0,0,2.5,73.54l-.27,0A2.38,2.38,0,0,1,0,71.15H0V65.53a5.46,5.46,0,0,1,5.44-5.44Zm26.09,45.22a3.74,3.74,0,0,1-1.49,1.46,6.91,6.91,0,0,1-3.15.52c-1.48,0-2.21-.39-2.21-1.17a1.47,1.47,0,0,1,.09-.36l16-28.23a6.19,6.19,0,0,1,.75-1.11,3.53,3.53,0,0,1,1.24-.77,5.87,5.87,0,0,1,2.25-.38c1.87,0,2.8.41,2.8,1.22a.87.87,0,0,1-.09.4L61.28,105.31ZM54,92.45a14.65,14.65,0,0,1-3.46-.36,7.93,7.93,0,0,1-2.72-1.26c-1.72-1.23-2.57-3.62-2.57-7.17s.9-5.77,2.7-7a11,11,0,0,1,6-1.48,11.34,11.34,0,0,1,6.08,1.48c1.81,1.18,2.71,3.49,2.71,7s-.86,6-2.57,7.17A10.75,10.75,0,0,1,54,92.45Zm0-4.37a.72.72,0,0,0,.58-.27c.39-.42.59-1.49.59-3.2A22.78,22.78,0,0,0,55,81.07a2.65,2.65,0,0,0-.41-1.2.78.78,0,0,0-.58-.22c-.79,0-1.18,1.4-1.18,4.21s.39,4.22,1.18,4.22ZM77.7,107.74a14.5,14.5,0,0,1-3.45-.36,7.89,7.89,0,0,1-2.73-1.26C69.8,104.89,69,102.5,69,99s.9-5.76,2.7-6.9a10.76,10.76,0,0,1,6-1.54,11.14,11.14,0,0,1,6.09,1.54q2.7,1.71,2.7,6.9c0,3.58-.85,6-2.57,7.17a10.75,10.75,0,0,1-6.22,1.62Zm0-4.37a.78.78,0,0,0,.58-.23c.4-.45.59-1.53.59-3.24a22.78,22.78,0,0,0-.18-3.54,2.65,2.65,0,0,0-.41-1.2.78.78,0,0,0-.58-.23c-.78,0-1.17,1.41-1.17,4.22s.39,4.22,1.17,4.22Zm29.53-38.48h-78v3.6a1.63,1.63,0,0,1,0,.31A2.1,2.1,0,0,1,25,68.49v-3.6H5.44a.64.64,0,0,0-.45.19.68.68,0,0,0-.19.45V69a10.38,10.38,0,0,1,4.83,2.53l.15.13a10.14,10.14,0,0,1,3.08,7.25v.24a10.14,10.14,0,0,1-3.08,7.24A10.36,10.36,0,0,1,4.84,89L5,94.79a10.26,10.26,0,0,1,7.92,10s0,.1,0,.12a10.28,10.28,0,0,1-8.06,9.93v2.6a.65.65,0,0,0,.64.64H25V114.7a1.45,1.45,0,0,1,0-.3,2.1,2.1,0,0,1,4.18.3v3.38h78a.67.67,0,0,0,.65-.64v-2.61a10.13,10.13,0,0,1-5.07-2.77,10.33,10.33,0,0,1-3-7.15v-.24a10.18,10.18,0,0,1,3.09-7.23h0a10.38,10.38,0,0,1,5-2.66V89a10.27,10.27,0,0,1-4.83-2.52l-.15-.13a10.19,10.19,0,0,1-3.09-7.24v-.25a10.37,10.37,0,0,1,3-7.15A10.14,10.14,0,0,1,107.88,69V65.53a.65.65,0,0,0-.2-.45.6.6,0,0,0-.45-.19ZM25,81.09a2.1,2.1,0,0,0,4.18.31,1.55,1.55,0,0,0,0-.31v-4.2a2.1,2.1,0,0,0-4.18-.3,1.45,1.45,0,0,0,0,.3v4.2ZM25,93.7a2.1,2.1,0,0,0,4.18.3,1.45,1.45,0,0,0,0-.3V89.5a2.1,2.1,0,0,0-4.18-.31,1.55,1.55,0,0,0,0,.31v4.2Zm0,12.6a2.1,2.1,0,0,0,4.18.31,1.63,1.63,0,0,0,0-.31v-4.2a2.1,2.1,0,0,0-4.18-.31,1.63,1.63,0,0,0,0,.31v4.2ZM55.75,43a2.76,2.76,0,0,0,1.08-1.39,2.7,2.7,0,0,0-4-3.13l-4.52,3a2.7,2.7,0,1,0,3,4.52l4.52-3Zm13.56-8.87a2.62,2.62,0,0,0,1.08-1.39,2.7,2.7,0,0,0-4-3.13l-4.53,3A2.76,2.76,0,0,0,60.75,34a2.7,2.7,0,0,0,4,3.13l4.52-3Z"/></svg>
                                <span class="side-menu__label">Coupon Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $sportsActive = '';
                        if($current_route == 'sport'
                                || $current_route == 'addsport'
                                || $current_route == 'editsport'){
                            $sportsActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $sportsActive }}">
                            <a href="{{ route('sport') }}" class="side-menu__item {{ $sportsActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M12 2C6.48 2 2 5.58 2 10.5c0 3.58 2.92 6.72 7 7.74V22h6v-3.76c4.08-1.02 7-4.16 7-7.74C22 5.58 17.52 2 12 2zm0 2c4.42 0 8 2.69 8 6s-3.58 6-8 6-8-2.69-8-6 3.58-6 8-6zm0 7.5l4-2.5-4-2.5-4 2.5 4 2.5zm0-2.67L10.59 8 12 7.17 13.41 8 12 9.33z"/>
                                </svg>
                                <span class="side-menu__label">Sports Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $faqActive = '';
                        if($current_route == 'faq' ||
                            $current_route == 'addfaq' ||
                            $current_route == 'editfaq'){
                            $faqActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $faqActive }}">
                            <a href="{{ route('faq') }}" class="side-menu__item {{ $faqActive }}">
                                <svg class="side-menu__icon" fill="#000000" width="1000px" height="1000px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="43.93" y="68.27" width="36.07" height="7.99" rx="2" ry="2"/><path d="M33.82,76.26h-4a2,2,0,0,1-2-2v-4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2v4A1.9,1.9,0,0,1,33.82,76.26Z" fill-rule="evenodd"/><path d="M33.82,58.41h-4a2,2,0,0,1-2-2v-4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2v4A1.9,1.9,0,0,1,33.82,58.41Z" fill-rule="evenodd"/><rect x="43.93" y="50.42" width="36.07" height="7.99" rx="2" ry="2"/><rect x="49.92" y="32.57" width="30.08" height="7.99" rx="2" ry="2"/><path d="M47.55,26.33l-2.12-2.12a1.44,1.44,0,0,0-2.12,0L30.08,37.32l-5.37-5.24a1.44,1.44,0,0,0-2.12,0L20.47,34.2a1.44,1.44,0,0,0,0,2.12l7.36,7.36a3,3,0,0,0,4.24,0L47.55,28.46A1.69,1.69,0,0,0,47.55,26.33Z" fill-rule="evenodd"/></svg>

                                <span class="side-menu__label">FAQ Management</span>
                            </a>
                        </li>
                        
                        @if(Auth::guard('admin')->User()->role == 'Super Admin')        
                        <?php
                        $cms = '';
                        if($current_route == 'cms' ||
                            $current_route == 'addcms' ||
                            $current_route == 'editcms'){
                            $cms = 'active';
                        }
                        ?>
                        <li class="slide {{ $cms }}">
                            <a href="{{ route('cms') }}" class="side-menu__item {{ $cms }}">
                                <svg class="side-menu__icon" fill="#000000" width="1000px" height="1000px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="43.93" y="68.27" width="36.07" height="7.99" rx="2" ry="2"/><path d="M33.82,76.26h-4a2,2,0,0,1-2-2v-4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2v4A1.9,1.9,0,0,1,33.82,76.26Z" fill-rule="evenodd"/><path d="M33.82,58.41h-4a2,2,0,0,1-2-2v-4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2v4A1.9,1.9,0,0,1,33.82,58.41Z" fill-rule="evenodd"/><rect x="43.93" y="50.42" width="36.07" height="7.99" rx="2" ry="2"/><rect x="49.92" y="32.57" width="30.08" height="7.99" rx="2" ry="2"/><path d="M47.55,26.33l-2.12-2.12a1.44,1.44,0,0,0-2.12,0L30.08,37.32l-5.37-5.24a1.44,1.44,0,0,0-2.12,0L20.47,34.2a1.44,1.44,0,0,0,0,2.12l7.36,7.36a3,3,0,0,0,4.24,0L47.55,28.46A1.69,1.69,0,0,0,47.55,26.33Z" fill-rule="evenodd"/></svg>
                                <span class="side-menu__label">CMS Management</span>
                            </a>
                        </li>
                        @endif                        
                        
                        <?php
                        $settingActive = '';
                        $openClass = '';
                        $submenuActive = '';

                        $routes = ['settinglist', 'addsetting', 'editsetting', 'emaillist', 'addemail', 'editemail', 'notification', 'addnotification', 'editnotification'];

                        if (in_array($current_route, $routes)) {
                            $settingActive = 'active';
                            $openClass = 'open';
                        }

                        if ($current_route == 'settinglist' || $current_route == 'addsetting' || $current_route == 'editsetting') {
                            $submenuActive = 'settinglist';
                        } else if($current_route == 'emaillist' || $current_route == 'addemail' || $current_route == 'editemail') {
                            $submenuActive = 'emaillist';
                        } else if($current_route == 'notification' || $current_route == 'addnotification' || $current_route == 'editnotification') {
                            $submenuActive = 'notification';
                        } 
                        ?>                        
                        
                        @if(Auth::guard('admin')->User()->role == 'Super Admin')                        
                        <li class="slide has-sub {{$settingActive}} {{$openClass}}">
                            <a href="javascript:void(0);" class="side-menu__item {{$settingActive}}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z"/></svg>
                                <span class="side-menu__label">Settings(Do not touch)</span>
                                <i class="fe fe-chevron-down side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1 mega-menu">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">Settings(Do not touch)</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('settinglist')}}" class="side-menu__item {{$submenuActive == 'settinglist' ? 'active' : ''}}">Setting Management</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('emaillist')}}" class="side-menu__item {{$submenuActive == 'emaillist' ? 'active' : ''}}">Email Templates</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('notification')}}" class="side-menu__item {{$submenuActive == 'notification' ? 'active' : ''}}">Notifications Management</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                       
                        <?php
                        $appversionActive = '';
                        if($current_route == 'appversion'){
                            $appversionActive = 'active';
                        }
                        ?>
                        @if(Auth::guard('admin')->User()->role == 'Super Admin')
                        <li class="slide {{ $appversionActive }}">
                            <a href="{{ route('appversion') }}" class="side-menu__item {{ $appversionActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                                <path d="M9 7C8.359 7 4.639 7 4 7 2.895 7 2 7.895 2 9c0 1.105.895 2 2 2 .639 0 4.359 0 5 0 1.105 0 2-.895 2-2C11 7.895 10.105 7 9 7zM11 4c0 .598 0 2 0 2S9.507 6 9 6C7.895 6 7 5.105 7 4s.895-2 2-2S11 2.895 11 4zM7 14c0 .641 0 4.361 0 5 0 1.105.895 2 2 2 1.105 0 2-.895 2-2 0-.639 0-4.359 0-5 0-1.105-.895-2-2-2C7.895 12 7 12.895 7 14zM4 12c.598 0 2 0 2 0s0 1.493 0 2c0 1.105-.895 2-2 2s-2-.895-2-2S2.895 12 4 12zM14 16c.641 0 4.361 0 5 0 1.105 0 2-.895 2-2 0-1.105-.895-2-2-2-.639 0-4.359 0-5 0-1.105 0-2 .895-2 2C12 15.104 12.895 16 14 16zM12 19c0-.598 0-2 0-2s1.493 0 2 0c1.105 0 2 .895 2 2 0 1.105-.895 2-2 2S12 20.104 12 19zM16 9c0-.641 0-4.361 0-5 0-1.105-.895-2-2-2-1.105 0-2 .895-2 2 0 .639 0 4.359 0 5 0 1.105.895 2 2 2C15.104 11 16 10.104 16 9zM19 11c-.598 0-2 0-2 0s0-1.493 0-2c0-1.105.895-2 2-2 1.105 0 2 .895 2 2S20.104 11 19 11z"></path>
                                </svg>
                                <span class="side-menu__label">APP Version(Do not touch)</span>
                            </a>
                        </li>
                        @endif
                        
                        <?php
                        $newsletterActive = '';
                        if($current_route == 'newsletterlist'){
                            $newsletterActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $newsletterActive }}">
                            <a href="{{ route('newsletterlist') }}" class="side-menu__item {{ $newsletterActive }}">
                                <svg class="side-menu__icon" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 118.1"><title>newsletter</title><path d="M115.17,33.29a3.8,3.8,0,0,1,2.49-.92,4.19,4.19,0,0,1,2.14.62,5.82,5.82,0,0,1,1.32,1.12,7.37,7.37,0,0,1,1.76,4.44v73.64a5.87,5.87,0,0,1-1.73,4.16h0A5.9,5.9,0,0,1,117,118.1H5.91a5.91,5.91,0,0,1-4.17-1.73h0A5.9,5.9,0,0,1,0,112.19V38.55a7.41,7.41,0,0,1,1.8-4.5A5.52,5.52,0,0,1,3.12,33a4.05,4.05,0,0,1,2.1-.6,3.68,3.68,0,0,1,2,.59l.2.17v-26a7.1,7.1,0,0,1,2.08-5h0a7.1,7.1,0,0,1,5-2.08h93.54a7.08,7.08,0,0,1,5,2.08,2.25,2.25,0,0,1,.21.24,7,7,0,0,1,1.87,4.77v26.2ZM70.85,43a3,3,0,0,1,0-6H83.64a3,3,0,0,1,0,6ZM39,43a3,3,0,0,1,0-6H51.77a3,3,0,0,1,0,6ZM54.2,60a3,3,0,0,1,0-6.05H68.42a3,3,0,0,1,0,6.05ZM27.86,26.07a3,3,0,0,1,0-6.05H42.29a3,3,0,0,1,0,6.05Zm52.48,0a3,3,0,0,1,0-6.05H94.77a3,3,0,0,1,0,6.05Zm-24.11,0a3,3,0,0,1,0-6.05h10a3,3,0,0,1,0,6.05ZM13.71,38.65,48.64,69.86l.15.14L60.84,80.76l48.08-42V7.09a.89.89,0,0,0-.17-.51l-.08-.08a.84.84,0,0,0-.59-.25H14.54A.84.84,0,0,0,14,6.5a.83.83,0,0,0-.24.59V38.65ZM114.56,41.4a3.09,3.09,0,0,1-1,.87L79.85,71.72l37.31,32.7h0V39.12l-2.6,2.28ZM58.92,86.68,46.81,75.86l-41.09,36v.33a.17.17,0,0,0,0,.13h0a.17.17,0,0,0,.13,0H117a.17.17,0,0,0,.13,0h0a.17.17,0,0,0,0-.13V112L75.52,75.5,62.7,86.7h0a2.85,2.85,0,0,1-3.78,0ZM42.52,72,5.72,39.15v65.13L42.52,72Z"/></svg>
                                <span class="side-menu__label">Newsletter Management</span>
                            </a>
                        </li>
                        
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div> 
                    </ul>
                </nav>
                 <!--End::nav--> 
            </div>
             <!--End::main-sidebar--> 

        </aside>
        <!-- Image preview Model -->
        <div class="modal fade" id="imagePreviewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="imagepreviewdiv">
                            <img class="priviewimage" src="">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Image preview Model -->
@yield('content')
        <!-- End::app-sidebar -->
        <!-- Footer Start -->
        <footer class="footer mt-auto py-3 bg-white text-center" style="display:none;">
            <div class="container">
                <span class="text-default"> Copyright © <?php echo date('Y'); ?>. 
                    <a target="_blank" href="https://www.octosglobal.com/" class="text-primary fw-semibold">Octos Global Solutions</a>.
                    Designed with <span class="bi bi-heart-fill text-danger"></span> by <a href="javascript:void(0);">
                        <span class="">Octos</span>
                    </a> All
                    rights
                    reserved
                </span>
            </div>
        </footer>
        <!-- Footer End -->

    </div>

    
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="fe fe-chevrons-up fs-16"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('public/admin/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('public/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('public/admin/assets/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('public/admin/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('public/admin/assets/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('public/admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/simplebar.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('public/admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>


    <!-- Apex Charts JS -->
    <script src="{{ asset('public/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Echarts JS -->
    <script src="{{ asset('public/admin/assets/libs/echarts/echarts.min.js') }}"></script>
    
    <!-- Chartjs Chart JS -->
    <script src="{{ asset('public/admin/assets/libs/chart.js/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


    <!-- Index JS -->
    <script src="{{ asset('public/admin/assets/js/index.js') }}"></script>
    
    
    <!-- Custom-Switcher JS -->
<!--    <script src="{{ asset('public/admin/assets/js/custom-switcher.min.js') }}"></script>-->

    <!-- Custom JS -->
    <script src="{{ asset('public/admin/assets/js/custom.js') }}"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('public/admin/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/validation.js') }}"></script>
    <!-- Alertify -->
    <script src="{{ asset('public/admin/assets/js/alertify.min.js')}}"></script>

    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('public/admin/assets/js/datatables.js')}}"></script>
    <!-- Quill Editor JS -->
    <!--<script src="{{ asset('public/admin/assets/libs/quill/quill.min.js')}}"></script>-->
    <!-- Internal Quill JS -->
    <!--<script src="{{ asset('public/admin/assets/js/quill-editor.js')}}"></script>-->
    <!-- Date & Time Picker JS -->
    <script src="{{ asset('public/admin/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{ asset('public/admin/assets/js/date&time_pickers.js')}}"></script>
    <script src="{{ asset('public/admin/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('public/admin/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/moment-timezone-with-data-2012-2022.min.js') }}"></script>
@yield('javascript')
<script type="text/javascript">
    function openImageInNewTab(src) {
        window.open(src, '_blank');
    }
    setTimeout(function() {
        //console.log(moment.tz.guess());
        
        var timeZone = moment.tz.guess();
        if (timeZone === 'Asia/Calcutta') {
          timeZone = 'Asia/Kolkata';
        }
        
        $.ajax({
            url: "{{ route('addcurrentusertimezone') }}",
            method: 'post',
            async: false,
            data: {
                _token: "{{ csrf_token() }}",
                timezone: timeZone,
            },
            success: function(data) {
                //console.log(data);
                return false;
            }
        })
    }, 1000);

    setInterval(function() {
        var admin_path = "{{ env('APP_URL') }}";
        //console.log(moment.tz.guess());
        
        var timeZone = moment.tz.guess();
        if (timeZone === 'Asia/Calcutta') {
          timeZone = 'Asia/Kolkata';
        }
        
        $.ajax({
            url: "{{ route('addcurrentusertimezone') }}",
            method: 'post',
            async: false,
            data: {
                _token: "{{ csrf_token() }}",
                timezone: timeZone,
            },
            success: function(data) {
                //console.log(data);
                return false;
            }
        })
    }, 100000);

</script>
<script>
    jQuery(document).on("click",".imagePriview",function(e){
        e.preventDefault();
        var image = jQuery(this).attr('src');
        if(image){
            jQuery('.priviewimage').attr('src',image);
            jQuery('#imagePreviewModel').modal('show');
        }
    });
</script>
<script>
    let html = document.querySelector("html");
        html.style.setProperty(
          "--primary-rgb",
          `216, 2, 26, 1`
        );
    localStorage.setItem(
          "primaryRGB",
          `216, 2, 26, 1`
        );
</script>
@if(Session::get("error"))
<script>
    jQuery(document).ready(function () {
        alertify.set('notifier', 'position', 'top-right');
        var notification = alertify.notify('{{Session::get("error")}}', 'error', 6);
    });
</script>
@endif
@if(Session::get("success"))
<script>
    jQuery(document).ready(function () {
        alertify.set('notifier', 'position', 'top-right');
        var notification = alertify.notify('{{Session::get("success")}}', 'success', 6);
    });
</script>
@endif
    
</body>

</html>