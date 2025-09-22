@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cms') }}">CMS Management </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Edit CMS</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit CMS
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="cmsForm" name="cmsForm" action="{{route('updatecms')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cms_id" value="{{base64_encode($cms->id)}}">
                            <div class="row gy-4">
                                <div class="col-lg-6 col-sm-6">
                                    <label for="document_name" class="form-label">Document Name<span class="required-str">*</span></label> 
                                    <input type="text" class="form-control" id="document_name" maxlength="32" name="document_name" value="{{$cms['document_name']}}" placeholder="Please Enter Document Name"/>
                                    @error('document_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label for="document_type" class="form-label">Type<span class="required-str">*</span></label> 
                                    <input type="text" class="form-control" id="document_type" name="document_type" value="{{$cms['document_name']}}" placeholder="Please Enter Document Type" disabled=""/>
                                    <input type="hidden" name="document_type" value="{{$cms['document_name']}}"/>
                                    @error('document_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                    
                                <div class="col-lg-12">
                                    <label for="content" class="form-label">Content<span class="required-str">*</span></label>
                                    <textarea class="form-control ckeditor" id="content" name="document_file" rows="3">{{$cms->document_file}}</textarea>
                                    @error('content')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('cms')}}" class="btn btn-danger">Cancel</a>
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
    $("#cmsForm").validate({
        ignore: [],
         rules: {
            document_name: {
                required: true,
                minlength : 2,
                maxlength : 32
            },
            document_type: {
                required: true,
            },
            document_file: {
                required: function ()
                {
                    CKEDITOR.instances.content.updateElement();
                },
            },
        },
        messages: {
            document_name: {
                required: 'Please enter document name',
                minlength : 'document name should be minimum 2 characters',
                maxlength : 'document name should be maximum 32 characters'
            },
            document_type: {
                required: 'Please select document type',
            },
            document_file: {
                required: 'Please enter document file',
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

            $('#loader').removeClass('d-none');
            form.submit();
        }
    });
});
</script>
@endsection
