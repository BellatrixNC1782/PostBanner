@extends('Layouts.admin')
@section('content')
<style>
    .password-icon {
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
                                        <form action="{{route('resetforgotpassword')}}" method="post" name="admin_login" id="reset_forgotpassword">
                                            @csrf
                                            <div class="text-center title-style mb-4">
                                                <h2 class="mb-2">Reset Password</h2>
                                            </div>
                                            <div class="input-group mt-3" id="show_hide_password">
                                                <button class="btn btn-light" type="button" id="button-addon4"><i class="fe fe-lock"></i></button>
                                                <input type="password" name="n_password" maxlength="16" id="n_password" class="form-control" placeholder="New Password" aria-describedby="button-addon4">
                                                <a href=""> <i class="fe fe-eye-off password-icon"></i> </a>
                                            </div>
                                            <div class="input-group mt-3" id="show_hide_password-1">
                                                <button class="btn btn-light" type="button" id="button-addon5"><i class="fe fe-lock"></i></button>
                                                <input type="password" name="con_password" maxlength="16" id="con_password" class="form-control" placeholder="Confirm Password" aria-describedby="button-addon5">
                                                <a href=""> <i class="fe fe-eye-off password-icon"></i> </a>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block px-4">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="text-center pt-4"> <div class="font-weight-normal fs-16">Forget it <a class="btn-link font-weight-normal" href="{{route('admincp')}}">Send me back</a></div> </div>
                                    </div>
                                </div>
                                <div class="card text-white bg-primary py-5 d-md-flex d-none page-content mt-0">
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
    $.validator.addMethod(
        "password_regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol."
    );
    jQuery("#reset_forgotpassword").validate({
        rules: {
            n_password: {
                required: true,
                minlength : 8,
                maxlength : 16,                
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
             },
            con_password: {
                required: true,
                minlength : 8,
                maxlength : 16,
                equalTo: "#n_password",
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
            }
        },
        messages: {
            n_password: {
                required: "Please enter new password",
                minlength : 'Password must contain atleast 8 characters',
                maxlength : 'Password must contain maximum 16 characters',
            },
            con_password: {
                required: "Please enter confirm password",
                equalTo: 'Password and confirm password does not match',
                minlength : 'Password must contain atleast 8 characters',
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
</script>
<script>
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

$(document).ready(function() {
    $("#show_hide_password-1 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password-1 input').attr("type") == "text"){
            $('#show_hide_password-1 input').attr('type', 'password');
            $('#show_hide_password-1 i').addClass( "fe-eye-off" );
            $('#show_hide_password-1 i').removeClass( "fe-eye" );
        }else if($('#show_hide_password-1 input').attr("type") == "password"){
            $('#show_hide_password-1 input').attr('type', 'text');
            $('#show_hide_password-1 i').removeClass( "fe-eye-off" );
            $('#show_hide_password-1 i').addClass( "fe-eye" );
        }
    });
});

</script>
@endsection
