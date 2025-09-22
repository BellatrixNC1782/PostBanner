<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>Anjana Yoga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="{{ asset('public/user/css/plugin/bootstrap.min.css') }}?{{ time() }}" />
    <link rel="stylesheet" href="{{ asset('public/user/css/plugin/fontawesome-free/css/all.min.css') }}?{{ time() }}" />
    <link href="{{ asset('public/user/css/style.css') }}?{{ time() }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/user/css/plugin/animate.css') }}?{{ time() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('public/images/favicons.ico') }}" type="image/x-icon">

    <!-- alert message link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <!--Captcha-->
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'submit' })
                .then(function(token) {
                    document.getElementById('recaptcha_token').value = token;
                });
        });
    </script>
    <style>
        span.error {
            color: red;
            text-align: left;
        }

    </style>
    <style>
        #cover {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            text-align: center;
            width: 100%;
            height: 100vh;
            background-color: rgb(16, 76, 154, .7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }


        .loading {
            display: flex;
            flex-wrap: wrap;
            animation: rotate 3s linear infinite;
        }

        .loading img {
            height: 115px;
        }

        @keyframes rotate {
            to {
                transform: rotate(360deg);
            }
        }


    </style>

    @yield('stylesheet')
</head>


<body class="homepage">
    <!-- ================= -->
    <!-- Site Header Starts -->
    <!-- ================= -->
    <header class="site-header">

        <?php $current_route = Route::currentRouteName();?>

        <!-- Main Site Navigation Bar -->
        <nav class="nav-bar">
            <div class="container-fluid">
                <div class="inner">
                    <!-- Logo -->
                    @if($current_route != 'home')
                    <a href="{{ route('home') }}" class="brand-wrap d-xl-none wow fadeInDown" data-wow-duration="1.0s" data-wow-delay="1.4s">
                        <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga">
                    </a>
                    @else
                    <a class="brand-wrap d-xl-none wow fadeInDown" data-wow-duration="1.0s" data-wow-delay="1.4s">
                        <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga">
                    </a>
                    @endif
                    <!-- Menu Toggler (For Mobile Devices) -->
                    <div class="menuToggle">
                        <img src="{{ asset('public/user/images/menu.svg') }}" alt="Menu">
                    </div>
                    <!-- Menu List -->
                    <div class="menu-links">
                        <!-- Menu Toggler (For Mobile Devices) -->
                        @if($current_route != 'home')
                        <a href="{{ route('home') }}" class="brand-wrap d-none d-xl-block">
                            <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga" class="wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.4s">
                        </a>
                        @else
                        <a class="brand-wrap d-none d-xl-block">
                            <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga" class="wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.4s">
                        </a>
                        @endif
                        
                        <div class="menuToggle">
                            <img src="{{ asset('public/user/images/close.svg') }}" alt="Menu"> Close
                        </div>
                        <ul class="menu">
                            <li class="menu-item active wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.1s"><a href="{{ route('home') }}">Home</a></li>
                            <?php
                                $services = App\Models\Services::select('id','name')->where('status', 'active')->get();
                            ?>
                            @if(!$services->isEmpty())
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.2s">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    services
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($services as $key => $service)
                                    <a class="dropdown-item" href="{{ route('servicedetail',['service_id' => base64_encode($service->id)]) }}">{{ $service->name }}</a>
                                    @endforeach

                                </div>
                            </li>
                            @endif
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.3s"><a href="{{ route('google.events') }}">Workshops</a></li>
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.4s"><a href="{{ route('becometeacher') }}">Become a Teacher</a></li>
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.5s">
                                <a class="nav-link dropdown-toggle" href="#" id="resonavbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Special Projects
                                </a>

                                <div class="dropdown-menu" aria-labelledby="resonavbarDropdown">
                                    <a class="dropdown-item" href="{{ route('prisonproject') }}">Prison Project</a>
                                </div>
                            </li>
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.6s"><a href="{{ route('aboutus') }}">About Us</a></li>
                            <li class="menu-item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.7s"><a href="{{ route('contactus') }}">Contact Us</a></li>

                        </ul>
                        <div class="action-btns wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.7s">
                            @if(!empty(Auth::User()) && $current_route != 'verificationemail')
                            <div class="logged">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(!empty(Auth::User()->image))
                                        <img class="profile-placeholder" src="{{ asset('public/uploads/'.Auth::User()->image) }}" alt="Anjana Yoga">
                                        @else
                                        <img class="profile-placeholder" src="{{ asset('public/user/images/profile-placeholder.svg') }}" alt="Anjana Yoga">
                                        @endif
                                     {{ Auth::User()->first_name.' '.Auth::User()->last_name }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('getprofile') }}"> <img src="{{ asset('public/user/images/setting-icon.png') }}" alt="Anjana Yoga"> Account Setting</a>
                                    <a class="dropdown-item" href="{{ route('userlogout') }}"> <img src="{{ asset('public/user/images/logout-icon.png') }}" alt="Anjana Yoga"> Logout</a>

                                </div>

                            </div>
                            @else
                                @if($current_route != 'login')
                                <a href="{{ route('login') }}" class="button btn-secondary wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.1s"> Sign In</a>
                                @endif
                                @if($current_route != 'signup')
                                <a href="{{ route('signup') }}" class="button btn-primary wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="1.2s"> Free Sign Up</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- ================= -->
    <!-- Site Header Ends -->
    <!-- ================= -->


    @yield('content')

    <footer>

        <div class="footer-top wow fadeInLeftBig" data-wow-duration="0.7s" data-wow-delay="0.9s">

            <div class="container">
                <div class="block d-flex flex-column flex-md-row align-items-start justify-content-between">
                    <div class="block-inner wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.7s">
                        <img src="{{ asset('public/user/images/call-icon.svg') }}" alt="call icon">
                        <a href="tel:+19193245503">+1 (919) 324-5503<span class="d-block">Contact us with phone</span></a>
                    </div>
                    <div class="block-inner wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.8s">
                        <img src="{{ asset('public/user/images/msg-icon.svg') }}" alt="msg-icon">
                        <a href="mailto:anjana.rathores@gmail.com">anjana.rathores@gmail.com <span class="d-block">Contact us with email</span></a>
                    </div>
                    <div class="block-inner wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.9s">
                        <img src="{{ asset('public/user/images/location-icon.svg') }}" alt="location icon">
                        <p> <a target="_blank" href="https://maps.app.goo.gl/YgstqAPsAB7yRCAr5">104 Bridewell Ct <br> Cary NC 27518</a> <span class="d-block"> Contact us with address </span> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <img src="{{ asset('public/user/images/footer-shape-left.png') }}" alt="footer shape" class="shape-left wow fadeInLeft" data-wow-duration="0.7s" data-wow-delay="0.9s">
            <img src="{{ asset('public/user/images/footer-shape-right.png') }}" alt="footer shape" class="shape-right wow fadeInLeft" data-wow-duration="0.7s" data-wow-delay="0.9s">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 position-relative footer-bottom-one">

                        <img class="footer-bg-image wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1s" src="{{ asset('public/user/images/footer-bg-image.svg') }}" alt="footer background">

                        <!-- Logo -->
                        
                        @if($current_route != 'home')
                        <a href="{{ route('home') }}" class="brand-wrap mb-3 d-block wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.9s">
                            <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga">
                        </a>
                        @else
                        <a class="brand-wrap mb-3 d-block wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.9s">
                            <img src="{{ asset('public/user/images/logo-1.svg') }}" alt="Anjana Yoga">
                        </a>
                        @endif
                        <p class="wow fadeInRight" data-wow-duration="0.7s" data-wow-delay="0.9s"> Anjana Yoga inspires wellness through yoga, mindfulness, and balance. Discover harmony and energy in every breath. </p>
                        <ul class="d-flex gap-2 social-icon align-items-center">
                            <li class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.9s"> <a target="_blank" href="https://www.facebook.com/anjana.rathores/"> <img src="{{ asset('public/user/images/facebook-icon.png') }}" alt="facebook icon"> </a> </li>
                            <li class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1s"> <a target="_blank" href="https://www.youtube.com/channel/UCanKO5nqSULsxUgf6kDdI-w"> <img src="{{ asset('public/user/images/youtube-icon.png') }}" alt="twitter icon"> </a> </li>
                            <li class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.1s"> <a target="_blank" href="https://www.linkedin.com/in/anjana-rathore-08a33a16/"> <img src="{{ asset('public/user/images/linkedin-icon.png') }}" alt="linkedin icon"> </a> </li>
                            <li class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.2s"> <a target="_blank" href="https://www.instagram.com/anjana.rathores/"> <img src="{{ asset('public/user/images/insta-icon.png') }}" alt="insta icon"> </a> </li>
                        </ul>
                    </div>
                    <div class="col-md-7 offset-md-1">
                        <h4 class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.9s"> Quick Links </h4>
                        <ul class="quick-links wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.9s">
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.9s" href="{{ route('aboutus') }}"> About us </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1s" href="{{ route('contactus') }}"> Contact Us </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.1s" href="{{ route('gallery') }}"> Gallery </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.2s" href="{{ route('webblogs') }}"> Blog </a> </li>

                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="0.9s" href="{{ route('google.events') }}"> Workshops </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1s" href="{{ route('becometeacher') }}"> Become a Teacher </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.1s" href="{{ route('terms-policies') }}"> Terms & Policies </a> </li>
                            <li> <a class="wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.2s" href="{{ route('disclaimer') }}"> Disclaimer </a> </li>
                        </ul>
                        <p class="border-top pt-3 wow fadeInUp" data-wow-duration="0.7s" data-wow-delay="1.3s"> Copyright ©2025 Anjana Yoga. All rights reserved and crafted with love by <a style="text-decoration: underline; color: #BCA083;" href="https://reinforceglobal.com/" target="_blank"> Reinforce Global </a> </p> 
                    </div>
                </div>
            </div>
        </div>



    </footer>

    <!-- loder -->
    <div id="cover" style="display:none;">
        <div class="loading">
            <img src="{{ asset('public/admin/assets/images/media/loader.svg') }}" alt="Fans Play Louder">
        </div>
    </div>
    
    <div class="modal fade" id="productimage" tabindex="-1" role="dialog" aria-labelledby="productimageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 p-0">

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('public/user/images/close-icon-video.svg') }}" alt="Anjana Yoga">
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="product-image-frame" alt="Anjana Yoga" class="image-radius image-video-url w-100">
                </div>

            </div>
        </div>
    </div>


    <script src="{{ asset('public/user/js/jquery.min.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/user/js/popper.min.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/user/js/bootstrap.bundle.min.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/user/js/custom.js') }}?{{ time() }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- <script src="{{ asset('public/user/js/script.js') }}"></script> -->
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <!-- Jquery validate -->

    <script src="{{ asset('public/admin/assets/js/jquery.validate.min.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/admin/assets/js/validation.js') }}?{{ time() }}"></script>
    <!--    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <!-- Alertify -->
    <script src="{{ asset('public/user/js/wow.min.js') }}?{{ time() }}" defer></script>
    <script src="{{ asset('public/user/js/lazysizes.min.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/admin/assets/js/alertify.min.js')}}?{{ time() }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        new WOW().init();
        });
    </script>


    <script>
        const video = document.getElementById("video");
        const circlePlayButton = document.getElementById("circle-play-b");

        function togglePlay() {
            if (video.paused || video.ended) {
                video.play();
            } else {
                video.pause();
            }
        }

        if (typeof(circlePlayButton) != 'undefined' && circlePlayButton != null) {
            circlePlayButton.addEventListener("click", togglePlay);
        }

        if (typeof(circlePlayButton) != 'undefined' && circlePlayButton != null) {
            video.addEventListener("playing", function() {
                circlePlayButton.style.opacity = 0;
            });
            video.addEventListener("pause", function() {
                circlePlayButton.style.opacity = 1;
            });
        }
        
        $(document).on("click",".image-view-btn",function(){
            var imageval = $(this).attr('src');
            
            if(imageval){
                $('#product-image-frame').attr('src',imageval);
                $('#productimage').modal('show');
            }
        });

    </script>


    @yield('javascript')

    @if(Session::get("error"))
    <script>
        jQuery(document).ready(function() {
            alertify.set('notifier', 'position', 'top-right');
            var notification = alertify.notify('{{Session::get("error")}}', 'error', 6);
            @php
            Session::forget('error');
            @endphp
        });

    </script>
    @endif
    @if(Session::get("success"))
    <script>
        jQuery(document).ready(function() {
            alertify.set('notifier', 'position', 'top-right');
            var notification = alertify.notify('{{Session::get("success")}}', 'success', 6);
            @php
            Session::forget('success');
            @endphp

        });

    </script>
    @endif

</body>

</html>
