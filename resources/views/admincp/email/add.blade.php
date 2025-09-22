@extends('Layouts.appadmin')
@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <!--<h4 class="page-title mb-0">User Management</h4>-->
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('emaillist') }}">Email Templates </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add Email</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Email
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="emailForm" name="emailForm" action="{{route('saveemail')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="subject" class="form-label">Email Subject<span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" id="subject" maxlength="750" value="" placeholder="Please Enter Email Subject">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="editor" class="form-label">Content<span class="text-danger">*</span></label>
<!--                                    <div id="editor" style="height: 200px; overflow-y: auto; border: 1px solid #ced4da; padding: 10px;"></div>
                                    <input type="hidden" name="content" id="content">-->
                                    <textarea class="form-control ckeditor" id="content" maxlength="5000" name="content"></textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('emaillist')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- End::app-content -->
@endsection
@section('javascript')
<script>
alertify.set('notifier', 'position', 'top-right');
$(document).ready(function() {
    $("#emailForm").validate({
        ignore: [],
         rules: {
            subject: {
                required: true,
                minlength: 2,
                maxlength: 750
            },
            subject: {
                required: true,
                minlength: 2,
                maxlength: 750
            },
            content: {
                required: function ()
                {
                    CKEDITOR.instances.content.updateElement();
                },
            },
        },
        messages: {
            subject: {
                required: "Please enter email subject",
                minlength: "Email subject should be minimum {0} characters",
                maxlength: "Email subject should be maximum {0} characters"
            },
            subject: {
                required: "Please enter email subject",
                minlength: "Email subject should be minimum {0} characters",
                maxlength: "Email subject should be maximum {0} characters"
            },
            content: {
                required: "Please enter email description",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.closest('.input-group').length) {
                element.closest('.input-group').after(error);
            } else {
                error.appendTo(element.parent().last());
            }
        },
        submitHandler: function (form) {
//            $('#content').val($('#editor').html());
//            var quillText = $('#editor').text().trim();
//
//            if (quillText === '') {
//                $('#content').val('');
//                alertify.notify('Please enter email content', 'error', 6);
//                return false;
//            } else {
//                $('#content').val(quillText);
//            }
            $('#loader').removeClass('d-none');
            form.submit();
        }
    });
});
</script>
@endsection
