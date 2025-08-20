@extends('Layouts.admin')
@section('content')

<div class="container">
    <div class="row login-container animated fadeInUp">
        <div class="col-md-7 col-md-offset-2 tiles white no-padding">
            <div class="p-t-30 p-l-40 p-r-40 xs-p-t-10 xs-p-l-10 xs-p-b-10">
                <h2 class="normal">
                    Sign in to Banner App Admin
                </h2>
            </div>
            <div class="p-l-40 p-r-40 xs-p-t-10 xs-p-l-10 xs-p-b-10">
                <br>
                <form action="{{ route('adminlogin') }}" class="login-form validate" method="post" name="admin_login" id="admin_login">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" aria-describedby="button-addon1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">Password</label> <span class="help"></span>
                            <input type="password" name="password" maxlength="16" id="password-field" placeholder="Enter Password" class="form-control" aria-describedby="button-addon3" required>
                            <a href=""><i class="fe fe-eye-off"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="control-group col-md-12">
                            <div class="checkbox checkbox check-success">
                                <a href="{{ route('forgotpassword') }}" class="px-0 text-default">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
                        </div>
                    </div>
                </form>
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
                minlength: 6,
                maxlength: 16,
            }
        },
        messages: {
            email: {
                required: "Please enter email address",
                email: 'Please enter valid email address',
            },
            password: {
                required: 'Please enter password',
                minlength: 'Password must contain atleast 6 characters',
                maxlength: 'Password must contain maximum 16 characters',
            }
        },
        errorPlacement: function (error, element) {
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

    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fe-eye-off");
                $('#show_hide_password i').removeClass("fe-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fe-eye-off");
                $('#show_hide_password i').addClass("fe-eye");
            }
        });
    });
</script>
@endsection
