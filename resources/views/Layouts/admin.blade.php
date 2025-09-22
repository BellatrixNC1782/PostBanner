<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Anjana Yoga </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('public/images/favicons.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('public/admin/assets/js/main.js') }}"></script>
    
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('public/admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{ asset('public/admin/assets/css/styles.min.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('public/admin/assets/css/icons.css') }}" rel="stylesheet" >
    <!-- Alertify -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/alertify.min.css')}}">
    
    <style>
        .btn-primary:hover {
            color: #fff !important;
        }
    </style>

</head>

<body> 
@yield('content')

<!-- Loader -->
<div id="loader" >
    <img src="{{ asset('public/admin/assets/images/media/loader.svg') }}" alt="">
</div>
<!-- Loader -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('public/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Custom-Switcher JS -->
<script src="{{ asset('public/admin/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/validation.js') }}"></script>
<!-- Alertify -->
<script src="{{ asset('public/admin/assets/js/alertify.min.js')}}"></script>
    

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
        function hideLoader() {
            const loader = document.getElementById("loader");
            loader.classList.add("d-none")
          }

          window.addEventListener("load", hideLoader);
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