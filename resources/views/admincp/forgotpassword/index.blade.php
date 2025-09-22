@extends('Layouts.admin')
@section('content')

<style>
.invalid-feedback {
    margin-top: -10px;
    margin-bottom: 15px;
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
                                        <form action="{{route('sendforgotpassword')}}" method="post" name="admin_login" id="forgotpassword_login">
                                            @csrf
                                            <div class="text-left title-style mb-4">
                                                <h2 class="mb-2">Forgot Password</h2>
                                            </div>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-light" type="button" id="button-addon2"><i class="fe fe-mail"></i></button>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email Address" aria-describedby="button-addon2">
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block px-4">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="text-center pt-4"> <div class=" fs-14">Forget it <a class="btn-link " href="{{route('admincp')}}">Send me back</a></div> </div>
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
    jQuery("#forgotpassword_login").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter email address",
                email: 'Please enter valid email address'
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
@endsection
