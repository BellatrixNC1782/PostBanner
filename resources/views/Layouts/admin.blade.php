<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Webarch - Responsive Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN PLUGIN CSS -->
        <link href="{{ asset('public/admin/assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" media="screen" />
        <link href="{{ asset('public/admin/assets/plugins/bootstrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/admin/assets/plugins/bootstrapv3/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('public/admin/assets/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/admin/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PLUGIN CSS -->
        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="{{ asset('public/admin/webarch/css/webarch.css') }}" rel="stylesheet" type="text/css" />
        <!-- END CORE CSS FRAMEWORK -->
        <!-- Alertify -->
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/alertify.min.css')}}">
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="error-body no-top lazy" data-original="{{ asset('public/admin/assets/img/work.jpg') }}" style="background-image: url('{{ asset('public/admin/assets/img/work.jpg') }}')">
        @yield('content')

        <!-- END CONTAINER -->
        <script src="{{ asset('public/admin/assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN JS DEPENDECENCIES-->
        <script src="{{ asset('public/admin/assets/plugins/jquery/jquery-1.11.3.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/bootstrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/jquery-block-ui/jqueryblockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/admin/assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>
        <!-- END CORE JS DEPENDECENCIES-->
        <!-- BEGIN CORE TEMPLATE JS -->
        <!--<script src="{{ asset('public/admin/assets/js/webarch.js') }}" type="text/javascript"></script>-->
        <script src="{{ asset('public/admin/assets/js/chat.js') }}" type="text/javascript"></script>
        <!-- END CORE TEMPLATE JS -->

        <!-- Alertify -->
        <script src="{{ asset('public/admin/assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('public/admin/assets/js/validation.js') }}"></script>
        <script src="{{ asset('public/admin/assets/js/alertify.min.js')}}"></script>
        
        @yield('javascript')

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