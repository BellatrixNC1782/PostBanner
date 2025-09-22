@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('successstories') }}">Success Stories</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Success Stories
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="faqaddform" name="profile_form" action="{{route('savesuccessstories')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Please Enter Name" />
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label" for="rating_star">Rating<span class="text-danger">*</span></label>
                                        <select class="form-control" id="rating_star" name="rating_star">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Please Enter Description"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-sm-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('successstories')}}" class="btn btn-danger">Cancel</a>
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
            name: {
                required: true,
                minlength: 2,
                maxlength: 155
            },
            rating_star: {
                required: true,
            },
            description: {
                required: true,
            }
        },
        messages: {
            name: {
                required: 'Please enter name',
                minlength: 'Name should be minimum 2 characters',
                maxlength: 'Name should be maximum 155 characters',
            },
            rating_star: {
                required: 'Please select rating',
            },
            description: {
                required: 'Please enter description',
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

    image.onchange = evt => {
        const [imagefile] = image.files
        if (imagefile) {
            $('#previewimage').css('display', 'block');
            previewimage.src = URL.createObjectURL(imagefile)
        }
    }

</script>
@endsection
