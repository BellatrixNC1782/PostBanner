@extends('Layouts.admin')
@section('content')
<style>
    .password a i {
        position: absolute;
        z-index: 11;
        right: 10px;
        top: 10px;
    }
</style>
<div class="page">
    <div class="page-single">
        <div class="p-sm-5 p-3">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-xl-6">
                            <div class="card-group mb-0">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <form action="{{ route('adminlogin') }}" method="post" name="admin_login" id="admin_login">
                                            @csrf
                                            <div class="text-center title-style mb-4">
                                                <h2 class="mb-2">Login</h2>
                                                <p class="text-muted fs-15">Sign in to your account</p>
                                            </div>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-light" type="button" id="button-addon1"><i class="fe fe-mail"></i></button>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" aria-describedby="button-addon1" required>
                                            </div>
                                            <div class="input-group mb-3 password" id="show_hide_password">
                                                <button class="btn btn-light" type="button" id="button-addon3"><i class="fe fe-lock"></i></button>
                                                <input type="password" name="password" maxlength="16" id="password-field" placeholder="Enter Password" class="form-control" aria-describedby="button-addon3" required>
                                                <a href=""><i class="fe fe-eye-off"></i></a>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-grid">
                                                    <button type="submit" class="btn btn-primary px-4">Login</button>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <a href="{{ route('forgotpassword') }}" class="btn box-shadow-0 px-0 text-default">Forgot password?</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
                                    <div class="text-center justify-content-center page-single-content my-auto">
                                        <div class="box">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <img src="{{ asset('public/images/logo-1.svg')}}" style="background: #fff; padding: 20px; border-radius: 35px;width:250px;" alt="img" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
jQuery("#admin_login").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
        minlength : 6,
        maxlength : 16,
        }
    },
    messages: {
        email: {
            required: "Please enter email address",
            email: 'Please enter valid email address',
        },
        password: {
            required: 'Please enter password',
            minlength : 'Password must contain atleast 6 characters',
            maxlength : 'Password must contain maximum 16 characters',
        }
    },
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        if (element.closest('.input-group').length) {
            element.closest('.input-group').after(error);
        } else {
            element.after(error);
        }
    },
    submitHandler: function (form) {
        $('#loader').removeClass('d-none');
        form.submit();
    }
});

$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fe-eye-off" );
            $('#show_hide_password i').removeClass( "fe-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fe-eye-off" );
            $('#show_hide_password i').addClass( "fe-eye" );
        }
    });
});
</script>
@endsection
