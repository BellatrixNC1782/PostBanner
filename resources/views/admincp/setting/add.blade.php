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
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('settinglist') }}">Setting Parameters </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add Setting</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Setting
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="settingForm" name="settingForm" action="{{route('savesetting')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="setting_title" class="form-label">Setting Title<span class="text-danger">*</span></label>
                                    <input type="text" name="setting_title" class="form-control" id="setting_title" value="" placeholder="Please Enter Setting Title">
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <label for="setting_value" class="form-label">Setting Value<span class="text-danger">*</span></label>
                                    <input type="text" name="setting_value" class="form-control" id="setting_value" value="" placeholder="Please Enter Setting Value">
                                </div>
                                 <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12">
                                    <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="type">                                        
                                        <option value="general">General</option>
                                        <option value="android">Android</option>
                                        <option value="ios">IOS</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('settinglist')}}" class="btn btn-danger">Cancel</a>
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
$(document).ready(function() {
    $("#settingForm").validate({
         rules: {
            setting_title: {
                required: true
            },
            setting_value: {
                required: true
            },
        },
        messages: {
            setting_title: {
                required: 'Please enter setting title'
            },
            setting_value : {
                required: 'Please enter setting value'
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
});
</script>
@endsection
