<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title> Post Banner </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="{{ asset('public/images/favicons11.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('public/web/css/bootstrap.min.css') }}" />

    <link href="{{ asset('public/web/css/style.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('public/web/css/responsive.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('public/web/css/alertify.min.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    @yield('stylesheet')
</head>

<body>
    <!------------------------news details section start----------------------------->
    <section class="privacy-policy content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    {!! @$termscondition->document_file !!}
                </div>
            </div>
        </div>
    </section>
    <!---------------------------End---------------------------------->
    <script src="{{ asset('public/web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/web/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/web/js/alertify.min.js') }}"></script>
    <script src="{{ asset('public/web/js/validate.js') }}"></script>

    <script src="{{ asset('public/web/js/script.js') }}"></script>


    <!-- Swiper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js "></script>

</body>

</html>