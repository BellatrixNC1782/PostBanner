@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('serviceplan') }}">Service Plan</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Service Plan
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="faqaddform" name="profile_form" action="{{route('saveserviceplan')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="service_id">Service<span class="text-danger">*</span></label>
                                        <select class="form-control" id="service_id" name="service_id">
                                            <option value="">Select Service</option>
                                            @foreach($services as $key => $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach()
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Plan Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="Please Enter Plan Name" />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="duration_type">Type<span class="text-danger">*</span></label>
                                        <select class="form-control" id="duration_type" name="duration_type">
                                            <option value="">Select Type</option>
                                            <option value="month">Month</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="amount">Amount ($)<span class="text-danger">*</span></label>
                                        <input type="number" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control" id="amount" name="amount" value="" placeholder="Please Enter Amount" />
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                    <label for="image" class="form-label">Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image" accept="image/png, image/jpeg" class="form-control" id="image">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload image with size 559px * 319px for proper resolution. </label>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                    <label for="previewimage" class="form-label"></label>
                                    <img id="previewimage" src="" alt="Image" height="100" width="100" class="mb-1" style="display:none;">
                                </div>

                                <div class="col-lg-12 col-sm-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('serviceplan')}}" class="btn btn-danger">Cancel</a>
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
            service_id: {
                required: true,
            },
            name: {
                required: true,
                minlength: 2,
                maxlength: 155
            },
            duration_type: {
                required: true,
            },
            amount: {
                required: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            service_id: {
                required: 'Please select service',
            },
            name: {
                required: 'Please enter plan name',
                minlength: 'Plan name should be minimum 2 characters',
                maxlength: 'Plan name should be maximum 155 characters',
            },
            duration_type: {
                required: 'Please select type',
            },
            amount: {
                required: 'Please enter amount',
            },
            image: {
                required: 'Please select image',
            },
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
