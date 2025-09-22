@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('blogs') }}">Blogs</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Blogs
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="faqaddform" name="profile_form" action="{{route('saveblogs')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">Category<span class="text-danger">*</span></label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach()
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="" placeholder="Please Enter Title" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="tags_ids">Tags<span class="text-danger">*</span></label>
                                        <select class="form-control" name="tags_ids[]" id="tags_ids" multiple>
                                            <option value="">Select Tags</option>
                                            @foreach($tags as $key => $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach()

                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Please Enter Description"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <label for="image" class="form-label">Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image" accept="image/png, image/jpeg" class="form-control" id="image">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload image with size 750px * 422px for proper resolution. </label>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <label for="previewimage" class="form-label"></label>
                                    <img id="previewimage" src="" alt="Image" height="100" width="100" class="mb-1" style="display:none;">
                                </div>

                                <div class="col-lg-12 col-sm-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('blogs')}}" class="btn btn-danger">Cancel</a>
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
    $(document).ready(function() {
        const multipleCancelButton = new Choices(
            '#tags_ids', {
                allowHTML: true,
                removeItemButton: true,
            }
        );
    });

    alertify.set('notifier', 'position', 'top-right');
    jQuery("#faqaddform").validate({
        ignore: [],
        rules: {
            category_id: {
                required: true,
            },
            title: {
                required: true,
                minlength: 2,
                maxlength: 155
            },
            description: {
                required: function() {
                    CKEDITOR.instances.description.updateElement();
                },
                minlength: 10,
            },
            image: {
                required: true,
            },
            /*tags_ids[]: {
                required: true,
            },*/
        },
        messages: {
            title: {
                required: 'Please enter title',
                minlength: 'Title should be minimum 2 characters',
                maxlength: 'Title should be maximum 155 characters',
            },
            description: {
                required: 'Please enter description',
                minlength: 'Description should be minimum 10 characters',
            },
            image: {
                required: 'Please select image',
            },
            /*tags_ids[]: {
                required: 'Please select tags',
            },*/
            category_id: {
                required: 'Please select category',
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
