@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <!--<h4 class="page-title mb-0">Profile Management</h4>-->
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Profile Management</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Profile
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="profile_form" name="profile_form" action="{{route('updateprofile')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" maxlength="32" id="first_name" value="{{$user_detail->first_name}}" placeholder="Please Enter First Name">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="last_name" class="form-label">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" maxlength="32" id="last_name" value="{{$user_detail->last_name}}" placeholder="Pleae Enter Last Name">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{$user_detail->email}}" placeholder="Please Enter email">
                                    <!--<p class="mt-2" style="color: var(--primary-color);"><b>Note:</b> if you change your email address, you need to verify it by checking your updated email inbox.</p>-->
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="number" class="form-label">Phone Number<span class="text-danger">*</span></label>
                                    <input name="number" class="form-control" id="number" value="{{$user_detail->number}}" placeholder="Please Enter Phone Number" maxlength="12">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="image" class="form-label">Profile Picture</label>
                                    <input type="file" name="image" onchange="previewImage(this);" class="form-control" id="image">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <div class="user-pic">
                                        <span class="avatar avatar-xxl avatar-rounded">
                                            @if(!empty($user_detail->image))
                                            <img id="preview" alt="user-img"class="mb-1" src="{{ asset('public/uploads/admin/'.$user_detail->image) }}">
                                            @else
                                            <img id="preview" src="{{ asset('public/images/default.png') }}" alt="user-img" class="mb-1">
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Reset Password
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="change_password_form" name="change_password_form" action="{{route('updatepassword')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="c_password" class="form-label">Current Password<span class="text-danger">*</span></label>
                                    <input type="password" name="c_password" class="form-control" id="c_password" placeholder="Please Enter Current Password">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="n_password" class="form-label">New Password<span class="text-danger">*</span></label>
                                    <input type="password" name="n_password" class="form-control" maxlength="16" id="n_password" placeholder="Please Enter New Password">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="con_password" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                    <input type="password" name="con_password" class="form-control" maxlength="16" id="con_password" placeholder="Please Enter Confirm Password">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.8/jquery.inputmask.bundle.min.js"></script>
<script>
$("#number").on("change keyup paste", function (e) {
    var t, n = $(this).val();
    if (8 != e.keyCode) {
        var r = (n = n.replace(/[^0-9]/g, "")).substr(0, 3),
                s = n.substr(3, 3),
                a = n.substr(6, 4);
        r.length < 3 ? t = "" + r : 3 == r.length && s.length < 3 ? t = "" + r + "" + s : 3 == r.length && 3 == s.length && (t = "" + r + "-" + s + "-" + a), $("#number").val(t)
    }
});
$('#number').trigger('keyup');
</script>
<script>
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\d{3}-\d{3}-\d{4}$/.test(value);
    }, "Please enter a valid phone number");
    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Letters and spaces only please");
    jQuery("#profile_form").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 32,
                lettersonly: true
            },
            last_name: {
                required: true,
                minlength: 2,
                maxlength: 32,
                lettersonly: true
            },
            email: {
                required: true,
                email: true
            },
            number: {
                required: true,
                customphone: true,
            }
        },
        messages: {
            first_name: {
                required: 'Please enter first name',
                minlength: 'First name should be minimum 2 characters',
                maxlength: 'First name should be maximum 32 characters',
                lettersonly: "Please enter letters only"
            },
            last_name: {
                required: 'Please enter last name',
                minlength: 'Last name should be minimum 2 characters',
                maxlength: 'Last name should be maximum 32 characters',
                lettersonly: "Please enter letters only"
            },
            email: {
                required: "Please enter email.",
                email: 'Please enter valid email.'
            },
            number: {
                required: "Please enter phone number.",
                minlength: "Phone number should be greater than 9 digits.",
                maxlength: "Phone number should be less than 12 digits.",
                //                number: "Please enter a valid mobile number."
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
    function previewImage(input) {
        var file = $("input[type=file]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function () {
                $("#preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    $.validator.addMethod(
        "password_regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol."
    );
    jQuery("#change_password_form").validate({
        rules: {
            c_password: {
                required: true
            },
            n_password: {
                required: true,
                minlength : 8,
                maxlength : 16,
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
            },
            con_password: {
                required: true,
                equalTo: "#n_password",
                minlength : 8,
                maxlength : 16,
                password_regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/,
            }
        },
        messages: {
            c_password: {
                required: 'Please enter current password.',
            },
            n_password: {
                required: 'Please enter new password.',
                minlength : 'New Password should be minimum 8 characters',
                maxlength : 'New Password should be maximum 16 characters',
                //pattern   : 'New Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol.',
            },
            con_password: {
                required: 'Please enter confirm password.',
                equalTo: 'Password and confirm password does not match.',
                minlength : 'Confirm password should be minimum 8 characters',
                maxlength : 'Confirm password should be maximum 16 characters',
                //pattern   : 'Confirm password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol.',
            },
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
</script>
@endsection