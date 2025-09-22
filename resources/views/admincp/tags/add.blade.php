@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('tags') }}">Tag</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Tag
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="faqaddform" name="profile_form" action="{{route('savetag')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="" placeholder="Please Enter Title" />
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('tags')}}" class="btn btn-danger">Cancel</a>
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
<script>
    alertify.set('notifier', 'position', 'top-right');
    jQuery("#faqaddform").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                minlength: 2,
                maxlength: 155
            }
        },
        messages: {
            title: {
                required: 'Please enter title',
                minlength: 'Title should be minimum 2 characters',
                maxlength: 'Title should be maximum 155 characters',
            }
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.closest('.input-group').length) {
                element.closest('.input-group').after(error);
            } else {
                error.appendTo(element.parent().last());
            }
        },
        submitHandler: function(form) {
            $('#loader').removeClass('d-none');
            form.submit();
        }
    });

</script>
@endsection
