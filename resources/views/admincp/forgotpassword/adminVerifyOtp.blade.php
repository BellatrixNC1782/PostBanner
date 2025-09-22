@extends('Layouts.admin')
@section('content')

<div class="page">
    <div class="page-single">
        <div class="p-5">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xxl-6">
                            <div class="card-group mb-0">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <div class="text-center title-style mb-4">
                                            <h2 class="mb-2">Verify Your Account</h2>
                                            <p class="text-muted fs-15">Enter the 4 digit code.</p>
                                        </div>                                        
                                        <form method="POST" id="forgotpassword_login" name="forgotpassword_login" action="{{ route('verifyforgototp') }}" >
                                            @csrf
                                            <div class="row mb-3"> 
                                                <div class="col-3"> 
                                                    <input type="text" class="form-control p-0 form-control-lg text-center" id="otp_box1" name="otp_box1" maxlength="1"> 
                                                </div> 
                                                <div class="col-3"> 
                                                    <input type="text" class="form-control p-0 form-control-lg text-center" id="otp_box2" name="otp_box2" maxlength="1"> 
                                                </div> 
                                                <div class="col-3"> 
                                                    <input type="text" class="form-control p-0 form-control-lg text-center" id="otp_box3" name="otp_box3" maxlength="1"> 
                                                </div> 
                                                <div class="col-3"> 
                                                    <input type="text" class="form-control p-0 form-control-lg text-center" id="otp_box4" name="otp_box4" maxlength="1"> 
                                                </div>
                                            </div> 
                                            <div class="form-check mb-3">
                                                <div class="timer_wrap">Resend in: <span id="timer"></span></div>
                                            </div>
                                            <div class="form-check mb-3"id="resend_btn" style="display:none;" onclick="resendotp()">
                                                <label class="form-check-label me-2 " for="defaultCheck1">
                                                    Did not recieve a code ?
                                                </label><a  class="text-primary" style="cursor: pointer;">Resend</a>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-grid">
                                                    <button type="submit" class="btn btn-primary px-4 verify-btn">Verify</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="text-center pt-4">
                                            <div class="font-weight-normal fs-14 text-danger">Don't share verification code with anyone</div>
                                        </div>
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
    
    $(".verify-btn").on("click", function(){
        f1 = $('#otp_box1').val();
        f2 = $('#otp_box2').val();
        f3 = $('#otp_box3').val();
        f4 = $('#otp_box4').val();
        
        var num = parseInt(f1);
        var num1 = parseInt(f2);
        var num2 = parseInt(f3);
        var num3 = parseInt(f4);
        
        if(isNaN(num) || num < 0 || isNaN(num1) || num1 < 0 || isNaN(num2) || num2 < 0 || isNaN(num3) || num3 < 0 || isNaN(num4) || num4 < 0){
                alertify.set('notifier', 'position', 'top-right');
                event.preventDefault();
                return alertify.notify('Please enter valid verification Code', 'error', 6);
                return false;
        }
      });
    
    $("input").keyup(function () {
        if (this.value.length == this.maxLength)
        {
            $(this).parent().next().find('input').focus()
        } else if (this.value.length == 0) {
            $(this).parent().prev().find('input').focus()
        }
    });
    jQuery("#forgotpassword_login").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter email.",
                email: 'Please enter valied email.'
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
var admin_path = "{{ env('ADMIN_URL') }}";
$(document).ready(function(){
    var loc = document.referrer;
    var path = document.hash = '{{route("forgotpassword")}}';
    if(loc == path){
        loadeTimer();
    }else{        
        $('#resend_btn').show();
        $('.timer_wrap').hide();
    }
    return false;
    
});
function loadeTimer() {
    let timerOn = true;
    var RESEND_OTP_SECOND = '{{ env('RESEND_OTP_SECOND',60) }}';

    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('timer').innerHTML = m + ':' + s;
        remaining -= 1;

        if (remaining >= 0 && timerOn) {
            setTimeout(function () {
                timer(remaining);
            }, 1000);
            return;
        }
        if (!timerOn) {
            return;
        }
        $('#resend_btn').show();
        $('.timer_wrap').hide();
    }
    timer(RESEND_OTP_SECOND);
}

    var admin_path = "{{env('ADMIN_URL') }}";
    function resendotp() {
        $.ajax({
            url: admin_path + 'resendotp',
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $("#cover").show();
            },
            complete: function() {
                $("#cover").hide();
            },
            success: function (response) {

                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $('#resend_btn').hide();
                loadeTimer();
                $('.timer_wrap').show();
                alertify.set('notifier', 'position', 'top-right');
                return alertify.notify('Resend verification code successfully', 'success', 6);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertify.set('notifier', 'position', 'top-right');
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Edit Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>
@endsection
