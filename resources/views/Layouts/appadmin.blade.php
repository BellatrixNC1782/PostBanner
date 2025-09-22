<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

<!-- Meta Data -->
<meta charset="UTF-8">
<meta name="google" content="notranslate">
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title> Anjana Yoga </title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
<meta name="Author" content="Spruko Technologies Private Limited">
<meta name="keywords" content="dashboard,admin,template dashboard,html css templates,admin panel,admindashboard,dashboard bootstrap 5,html and css,bootstrap admin dashboard,bootstrap 5 admin template,admin panel bootstrap template,admin dashboard,html template,dashboard,template,bootstrap">

<!-- Favicon -->
<link rel="icon" href="{{ asset('public/images/favicons.ico') }}" type="image/x-icon">

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
    a.logout-link i {
        font-size: 19px !important;
        color: #c9393a !important;
        border-color: #c9393a !important;
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
                    <!-- Start::header-element -->
                    <div class="header-element header-theme-mode">
                    </div>
                    <!-- End::header-element -->                    
                
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="{{ route('admincplogout') }}" class="header-link logout-link" id="mainHeaderProfile" aria-expanded="false">
                            <i class="ti ti-logout header-link-icon fs-19"></i>
                        </a>
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
                    <img src="{{ asset('public/images/logo-toggle.png') }}" alt="logo" class="toggle-logo">
                    <img src="{{ asset('public/images/logo.svg') }}" alt="logo" class="desktop-dark">
                    <img src="{{ asset('public/images/logo-toggle.png') }}" alt="logo" class="toggle-dark">
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
                                        <img src="{{ asset('public/uploads/admin/'.Auth::guard('admin')->User()->image) }}" class="mb-1" alt="User Image">
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
                        $profileActive = '';
                        if($current_route == 'profile'){
                            $profileActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $profileActive }}">
                            <a href="{{ route('profile') }}" class="side-menu__item {{ $profileActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="19.5" height="19.5" viewBox="0 0 19.5 19.5">
                                  <g id="profile" transform="translate(-2.25 -2.25)">
                                    <path id="Path_1" data-name="Path 1" d="M21,12a9,9,0,1,1-9-9,9,9,0,0,1,9,9" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                    <path id="Path_2" data-name="Path 2" d="M14.5,9.25A2.5,2.5,0,1,1,12,6.75a2.5,2.5,0,0,1,2.5,2.5M17,19.5c-.317-6.187-9.683-6.187-10,0" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                  </g>
                                </svg>
                                <span class="side-menu__label">Profile Management</span>
                            </a>
                        </li>
                        
                        <?php
                        $dashboardActive = '';
                        if($current_route == 'dashboard'){
                            $dashboardActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $dashboardActive }}">
                            <a href="{{ route('dashboard') }}" class="side-menu__item {{ $dashboardActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="18.03" height="18.036" viewBox="0 0 18.03 18.036">
                                  <path id="dashboard" d="M3,6.444c0-1.624,0-2.435.505-2.939S4.819,3,6.444,3s2.435,0,2.939.505.505,1.315.505,2.939,0,2.435-.505,2.939-1.315.505-2.939.505-2.435,0-2.939-.505S3,8.068,3,6.444m0,9.649c0-1.624,0-2.435.505-2.939s1.315-.505,2.939-.505,2.435,0,2.939.505.505,1.315.505,2.939,0,2.435-.505,2.939-1.315.505-2.939.505-2.435,0-2.939-.505S3,17.717,3,16.093m9.642-9.65c0-1.624,0-2.435.505-2.939S14.463,3,16.086,3s2.435,0,2.939.505.505,1.315.505,2.939,0,2.435-.505,2.939-1.315.505-2.939.505-2.435,0-2.939-.505-.505-1.315-.505-2.939m0,9.649c0-1.624,0-2.435.505-2.939s1.315-.505,2.939-.505,2.435,0,2.939.505.505,1.315.505,2.939,0,2.435-.505,2.939-1.315.505-2.939.505-2.435,0-2.939-.505-.505-1.315-.505-2.939" transform="translate(-2.25 -2.25)" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                </svg>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        
                        <?php
                        $usermanagemaentActive = '';
                        if($current_route == 'userlist'
                                || $current_route == 'viewuser'){
                            $usermanagemaentActive = 'active';
                        }
                        ?>
                        <li class="slide {{ $usermanagemaentActive }}">
                            <a href="{{ route('userlist') }}" class="side-menu__item {{ $usermanagemaentActive }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="18.03" height="15.734" viewBox="0 0 18.03 15.734">
                                  <path id="usermanagement" d="M19.53,18.484c0-1.919-1.534-4.654-3.673-5.259M14.02,18.484a5.945,5.945,0,0,0-5.51-5.51A5.945,5.945,0,0,0,3,18.484M11.265,7A2.755,2.755,0,1,1,8.51,4.25,2.755,2.755,0,0,1,11.265,7M14.02,9.76a2.755,2.755,0,1,0,0-5.51" transform="translate(-2.25 -3.5)" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                </svg>
                                <span class="side-menu__label">User Management</span>
                            </a>
                        </li> 
                        
                        
                        <?php
                        $appversionActive = '';
                        if($current_route == 'appversion'){
                            $appversionActive = 'active';
                        }
                        ?>
                       
                        
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
                                <svg class="side-menu__icon fill-icon" xmlns="http://www.w3.org/2000/svg" width="22.078" height="18.486" viewBox="0 0 22.078 18.486">
                                  <g id="cms" transform="translate(0.38 0.212)">
                                    <g id="Layer_1" data-name="Layer 1" transform="translate(-0.18 -0.012)">
                                      <path id="Path_37" data-name="Path 37" d="M-.17,2.468A3.157,3.157,0,0,1,0,2.109,1.074,1.074,0,0,1,.983,1.6h2.4V1.105A1.065,1.065,0,0,1,4.424-.005c.077-.006.155-.006.233-.006H16.445a1.906,1.906,0,0,1,.481.049A1.049,1.049,0,0,1,17.7,1.1c0,1.107,0,2.215,0,3.322v.226c.136.027.256.04.369.075a1.074,1.074,0,0,1,.751,1.021c.011.288.007.579,0,.868,0,.246-.133.387-.331.38s-.3-.143-.3-.382c0-.261,0-.522,0-.783a.463.463,0,0,0-.522-.521H3.424c-.374,0-.524.169-.525.579v8.508A2.081,2.081,0,0,1,2.6,15.7h.282l9.524,0a.582.582,0,0,0,.382-.157.6.6,0,0,0,.177-.913c-.207-.366-.166-.389-.613-.391s-.593-.135-.594-.59c0-.346,0-.691,0-1.037,0-.315.173-.518.484-.479a.607.607,0,0,0,.771-.52c.113-.4.157-.391-.144-.693-.339-.339-.339-.531,0-.869.234-.235.467-.471.7-.7a.456.456,0,0,1,.719,0c.126.124.244.255.361.377.292-.113.564-.218.835-.334a.192.192,0,0,0,.082-.143c.011-.155,0-.31.005-.466a.44.44,0,0,1,.452-.478q.6-.016,1.206,0a.444.444,0,0,1,.454.459c0,.056,0,.113,0,.169,0,.466,0,.466.5.589v-1.3c0-.254.116-.389.317-.387s.313.138.316.4c0,.353,0,.706,0,1.058,0,.047.006.094.012.174.056-.045.084-.069.113-.1a.47.47,0,0,1,.767.012c.251.248.5.5.748.748a.456.456,0,0,1,0,.72c-.13.129-.272.245-.384.345.121.3.217.564.329.812a.235.235,0,0,0,.163.113c.154.016.31,0,.465.007a.446.446,0,0,1,.469.486q.007.571,0,1.142c0,.3-.169.508-.467.476a.637.637,0,0,0-.8.54c-.1.383-.151.37.138.659.361.361.362.545.006.9-.23.23-.457.461-.689.688s-.5.259-.713-.006c-.259-.322-.511-.421-.87-.169a1.828,1.828,0,0,1-.414.156c0,.182,0,.371,0,.56a.448.448,0,0,1-.481.5q-.572.015-1.143,0c-.331-.007-.516-.178-.483-.5.041-.4-.06-.629-.489-.745s-.424-.165-.744.153-.517.316-.841-.006c-.2-.2-.379-.487-.626-.588A2.519,2.519,0,0,0,12,16.343H1.541A1.566,1.566,0,0,1-.152,15.114c0-.012-.018-.02-.028-.03V4.457a.9.9,0,0,1,.208-.165c.246-.1.427.077.427.4V14.809a.9.9,0,0,0,1.8.06c.01-.1.01-.211.01-.317V5.874A1.09,1.09,0,0,1,3,4.733a3.639,3.639,0,0,1,.376-.083V2.241c-.847,0-1.676-.007-2.506,0a.407.407,0,0,0-.4.42,2.669,2.669,0,0,1-.012.442.4.4,0,0,1-.19.269c-.1.033-.235-.032-.35-.064C-.116,3.3-.138,3.256-.17,3.23Zm4.188,2.19h13.05V1.179c0-.4-.151-.554-.548-.554H4.567c-.4,0-.548.16-.548.554V4.658ZM19.3,9.9c-.056.065-.113.137-.173.2a2.627,2.627,0,0,1-.195.194.462.462,0,0,1-.564.075c-.313-.141-.629-.277-.951-.4a.455.455,0,0,1-.357-.481c0-.173,0-.347,0-.525h-.82a.2.2,0,0,0-.021.049c0,.155,0,.31-.006.465a.472.472,0,0,1-.372.5c-.309.113-.615.24-.914.379a.466.466,0,0,1-.629-.1c-.118-.117-.226-.244-.313-.339l-.643.6c.12.113.242.217.356.332a.467.467,0,0,1,.1.629c-.138.3-.264.6-.378.913a.469.469,0,0,1-.5.369c-.169,0-.334,0-.5,0v.847c.18,0,.342,0,.5,0a.475.475,0,0,1,.5.372c.113.309.239.615.378.913a.461.461,0,0,1-.1.628c-.12.117-.259.215-.352.292l.627.653c.113-.116.226-.242.343-.36a.471.471,0,0,1,.6-.089c.306.139.618.269.932.388a.475.475,0,0,1,.369.5c0,.169,0,.335,0,.508h.847v-.523a.462.462,0,0,1,.36-.481c.315-.119.627-.248.932-.388a.468.468,0,0,1,.6.084c.125.123.237.259.335.367l.655-.621c-.126-.113-.253-.212-.367-.325a.471.471,0,0,1-.092-.646,9.45,9.45,0,0,0,.365-.874c.1-.288.217-.392.519-.4.165,0,.331,0,.494,0v-.847h-.538a.458.458,0,0,1-.465-.353c-.119-.315-.245-.628-.386-.934a.462.462,0,0,1,.089-.611c.12-.124.242-.247.344-.352Z" transform="translate(0.18 0.012)" fill="#5b6e88" stroke="#5b6e88" stroke-width="0.4"/>
                                      <path id="Path_38" data-name="Path 38" d="M72.116,219.334h-1.8a.759.759,0,0,1-.856-.861c0-.339-.005-.677,0-1.016a.713.713,0,0,1,.738-.759q1.9-.016,3.807,0a.715.715,0,0,1,.741.737c.014.38.014.761,0,1.142a.74.74,0,0,1-.794.755C73.343,219.339,72.729,219.334,72.116,219.334Zm-.029-.634c.6,0,1.2,0,1.8,0,.174,0,.239-.061.234-.234-.008-.31-.007-.621,0-.93,0-.155-.06-.211-.213-.211q-1.806.005-3.612,0c-.144,0-.2.053-.2.2.007.31.01.621,0,.93-.007.182.056.249.242.246C70.92,218.694,71.5,218.7,72.087,218.7Z" transform="translate(-65.529 -204.458)" fill="#5b6e88" stroke="#5b6e88" stroke-width="0.4"/>
                                      <path id="Path_39" data-name="Path 39" d="M71.579,136h1.584c.265,0,.41.12.4.323s-.148.31-.4.31h-3.19c-.256,0-.387-.113-.388-.317s.124-.315.383-.317Z" transform="translate(-65.652 -128.323)" fill="#5b6e88" stroke="#5b6e88" stroke-width="0.4"/>
                                      <path id="Path_40" data-name="Path 40" d="M71.008,110.385H69.971c-.255,0-.384-.117-.382-.324s.122-.308.37-.309q1.058,0,2.116,0c.239,0,.364.118.362.318s-.13.31-.372.313Z" transform="translate(-65.651 -103.554)" fill="#5b6e88" stroke="#5b6e88" stroke-width="0.4"/>
                                      <path id="Path_44" data-name="Path 44" d="M266.176,204.38a1.844,1.844,0,0,1-1.858-1.9,1.879,1.879,0,0,1,3.757.047A1.834,1.834,0,0,1,266.176,204.38Zm1.264-1.844a1.244,1.244,0,1,0-2.488-.006,1.244,1.244,0,0,0,2.488.006Z" transform="translate(-249.389 -189.308)" fill="#5b6e88" stroke="#5b6e88" stroke-width="0.4"/>
                                    </g>
                                  </g>
                                </svg>
                                <span class="side-menu__label">CMS Management</span>
                            </a>
                        </li>
                        
                        @endif
                        
                        <?php
                        $settingActive = '';
                        $openClass = '';
                        $submenuActive = '';

                        $routes = ['settinglist', 'addsetting', 'editsetting', 'emaillist', 'addemail', 'editblog' ,'notification', 'addnotification', 'editnotification'];

                        if (in_array($current_route, $routes)) {
                            $settingActive = 'active';
                            $openClass = 'open';
                        }

                        if($current_route == 'settinglist' || $current_route == 'addsetting' || $current_route == 'editsetting'){
                            $submenuActive = 'settinglist';
                        } else if($current_route == 'emaillist' || $current_route == 'addemail' || $current_route == 'editemail'){
                            $submenuActive = 'emaillist';
                        }else if($current_route == 'notification'|| $current_route == 'addnotification' || $current_route == 'editnotification'){
                            $submenuActive = 'notificationlist';
                        }
                        ?>
                        
                        @if(Auth::guard('admin')->User()->role == 'Super Admin')
                        <li class="slide has-sub {{$settingActive}} {{$openClass}}">
                            <a href="javascript:void(0);" class="side-menu__item {{$settingActive}}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="20.939" height="20.939" viewBox="0 0 20.939 20.939">
                                  <g id="settings" transform="translate(-2.25 -2.25)">
                                    <path id="Path_33" data-name="Path 33" d="M10.678,3.972A1.08,1.08,0,0,1,11.753,3h1.933a1.08,1.08,0,0,1,1.075.972l.036.36a8.639,8.639,0,0,1,2.386.988l.28-.229a1.08,1.08,0,0,1,1.447.072L20.276,6.53a1.08,1.08,0,0,1,.072,1.447l-.229.281a8.583,8.583,0,0,1,.988,2.384l.359.036a1.08,1.08,0,0,1,.973,1.075v1.933a1.08,1.08,0,0,1-.972,1.075l-.36.036a8.639,8.639,0,0,1-.988,2.386l.229.28a1.08,1.08,0,0,1-.072,1.447l-1.367,1.367a1.08,1.08,0,0,1-1.447.072l-.281-.229a8.639,8.639,0,0,1-2.384.988l-.036.359a1.08,1.08,0,0,1-1.075.973H11.753a1.08,1.08,0,0,1-1.075-.972l-.036-.36a8.639,8.639,0,0,1-2.386-.988l-.28.229a1.08,1.08,0,0,1-1.447-.072L5.163,18.907a1.08,1.08,0,0,1-.072-1.447l.229-.281a8.639,8.639,0,0,1-.988-2.384l-.36-.035A1.08,1.08,0,0,1,3,13.686V11.753a1.08,1.08,0,0,1,.972-1.075l.36-.036A8.639,8.639,0,0,1,5.32,8.257l-.229-.28A1.08,1.08,0,0,1,5.163,6.53L6.531,5.163a1.08,1.08,0,0,1,1.447-.072l.281.229a8.639,8.639,0,0,1,2.384-.988Z" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                    <path id="Path_34" data-name="Path 34" d="M14.9,12.2a2.7,2.7,0,1,0-2.7,2.7,2.7,2.7,0,0,0,2.7-2.7" transform="translate(0.519 0.519)" fill="none" stroke="#5b6e88" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                  </g>
                                </svg>
                                <span class="side-menu__label">Settings (Do not touch)</span>
                                <i class="fe fe-chevron-down side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1 mega-menu">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">Settings (Do not touch)</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('settinglist')}}" class="side-menu__item {{$submenuActive == 'settinglist' ? 'active' : ''}}">Config Parameters</a>
                                </li>
                                <!--<li class="slide">
                                    <a href="{{route('emaillist')}}" class="side-menu__item {{$submenuActive == 'emaillist' ? 'active' : ''}}">Email Templates</a>
                                </li>-->
                                
                            </ul>
                        </li>
                        @endif
                        
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
@yield('javascript')

<script>
    let html = document.querySelector("html");
        html.style.setProperty(
          "--primary-rgb",
          `131, 85, 254`
        );
        localStorage.setItem(
          "primaryRGB",
          `131, 85, 254`
        );
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