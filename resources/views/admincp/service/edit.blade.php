@extends('Layouts.appadmin')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('service') }}">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Edit</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit Service
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="serviceaddform" name="profile_form" action="{{route('updateservice')}}" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="service_id" value="{{ $service_detail->id }}">

                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Service Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $service_detail->name }}" placeholder="Please Enter Service Name" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="detail_title">Service Detail Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="detail_title" name="detail_title" value="{{ $service_detail->detail_title }}" placeholder="Please Enter Service Detail Title" />
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                    <label for="list_image" class="form-label">List Image<span class="text-danger">*</span></label>
                                    <input type="file" name="list_image" accept="image/png, image/jpeg" class="form-control" id="list_image">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload image with size 207px * 207px for proper resolution. </label>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                    <label for="previewlist" class="form-label"></label>
                                    <img id="previewlist" src="{{ $service_detail->list_image }}" alt="List Image" height="100" width="100" class="mb-1">
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                    <label for="detail_image" class="form-label">Detail Image<span class="text-danger">*</span></label>
                                    <input type="file" name="detail_image" accept="image/png, image/jpeg" class="form-control" id="detail_image">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload image with size 485px * 432px for proper resolution. </label>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                    <label for="previewdetail" class="form-label"></label>
                                    <img id="previewdetail" src="{{ $service_detail->detail_image }}" alt="Detail Image" height="100" width="100" class="mb-1">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="list_description">Service Description(List)<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="list_description" name="list_description" rows="4" placeholder="Please Enter Service Description">{{ $service_detail->list_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="detail_description">Service Description(Detail)<span class="text-danger">*</span></label>
                                        <textarea class="form-control ckeditor" id="detail_description" name="detail_description" rows="4" placeholder="Please Enter Service Description">{{ $service_detail->detail_description }}</textarea>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-sm-6">
                                    <label for="service_images" class="form-label">Service Images</label>
                                    <input type="file" name="service_images[]" accept="image/png, image/jpeg" class="form-control service_images" multiple id="service_images">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload images with size 581px * 423px for proper resolution. </label>
                                    <div class="row">
                                        <div class="col-lg-12 upload-files image-files">
                                            <p class="icount">{{ count($service_images) }} File(s) Uploaded</p>
                                            @if(!$service_images->isEmpty())
                                            @foreach($service_images as $key => $image)
                                            <div class="upload-list">
                                                <div class="d-flex align-items-center"> <img class="teamphoto" style="" src="{{ $image->image }}" alt="">
                                                    <h4 class="ms-2"> {{ $image->image_name }} </h4>
                                                </div> <img class="delete-btn deleteibtn" data-id="{{ $image->id }}" style="" src="{{asset('public/images/delete-icon-01.svg')}}" alt="">
                                            </div>
                                            @endforeach()
                                            @endif
                                        </div>
                                        <div class="remove_images"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label for="service_vedios" class="form-label">Service Videos</label>
                                    <input type="file" name="service_vedios[]" accept="video/mp4" class="form-control service_vedios" multiple id="service_vedios">
                                    <label class='pt-2 text-danger mb-2'>NOTE :- Please upload only mp4 videos. </label>
                                    <div class="row">
                                        <div class="col-lg-12 upload-files vedio-files">
                                            <p class="vcount">{{ count($service_vedios  ) }} File(s) Uploaded</p>
                                            @if(!$service_vedios->isEmpty())
                                            @foreach($service_vedios as $key => $vedio)
                                            <div class="upload-list d-flex align-items-center justify-content-between p-2 border mb-2">
                                                <div class="d-flex align-items-center">
                                                    <video class="video-thumb me-2" src="{{ $vedio->video }}" controls></video>
                                                    <span class="file-name">{{ $vedio->video_name }}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <label class="me-2 mb-0" style="font-size: 14px;">
                                                        <input type="hidden" name="VedioisPremium[]" value="{{ ($vedio->type == 'premium') ? '1' : '0' }}" class="premium-hidden">
                                                        <input type="hidden" name="service_vedio_id[]" value="{{ $vedio->id }}">
                                                        <input type="checkbox" {{ ($vedio->type == 'premium') ? 'checked' : '' }} class="form-check-input is-premium" value="1"> Is Premium
                                                    </label>
                                                    <input type="number" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control form-control-sm amount-input me-4 {{ ($vedio->type == 'premium') ? '' : 'd-none' }}" name="Vedioamount[]" value="{{ $vedio->amount }}" placeholder="Amount">
                                                    <img class="delete-btn deletevbtn"  data-id="{{ $vedio->id }}" src="{{asset('public/images/delete-icon-01.svg')}}" alt="Delete">
                                                </div>
                                            </div>
                                            @endforeach()
                                            @endif
                                        </div>
                                        <div class="remove_vedios"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    <a href="{{route('service')}}" class="btn btn-danger">Cancel</a>
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
    jQuery("#serviceaddform").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 155
            },
            detail_title: {
                required: true,
                minlength: 2,
                maxlength: 155
            },
            list_description: {
                required: true,
                minlength: 10
            },
            detail_description: {
                required: function() {
                    CKEDITOR.instances.detail_description.updateElement();
                },
                minlength: 10,
            },
//            list_image: {
//                required: true,
//            },
//            detail_image: {
//                required: true,
//            },
        },
        messages: {
            name: {
                required: 'Please enter service name',
                minlength: 'Service name should be between 2 to 155 characters',
                maxlength: 'Service name should be between 2 to 155 characters'
            },
            detail_title: {
                required: 'Please enter service detail title',
                minlength: 'Service detail title should be between 2 to 155 characters',
                maxlength: 'Service detail title should be between 2 to 155 characters'
            },
            list_description: {
                required: 'Please enter service description',
                minlength: 'Service description should be minimum 10 characters'
            },
            detail_description: {
                required: 'Please enter service description',
                minlength: 'Service description should be minimum 10 characters'
            },
            list_image: {
                required: 'Please select list image',
            },
            detail_image: {
                required: 'Please select detail image',
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
            let valid = true;
            let errorShown = false;

            $(".upload-list").each(function() {
                let isPremium = $(this).find(".is-premium").is(":checked");
                let amountInput = $(this).find(".amount-input");

                if (isPremium && amountInput.val().trim() === "") {
                    valid = false;

                    if (!errorShown) {
                        alertify.notify('Please enter amount for all premium videos', 'error', 6);
                        errorShown = true;
                    }

                    amountInput.addClass("is-invalid");
                } else {
                    amountInput.removeClass("is-invalid");
                }
            });

            if (!valid) {
                return false; // stop submit
            }

            $('#loader').removeClass('d-none');
            form.submit();
        }
    });

    detail_image.onchange = evt => {
        const [file] = detail_image.files
        if (file) {
            $('#previewdetail').css('display', 'block');
            previewdetail.src = URL.createObjectURL(file)
        }
    }

    list_image.onchange = evt => {
        const [listfile] = list_image.files
        if (listfile) {
            $('#previewlist').css('display', 'block');
            previewlist.src = URL.createObjectURL(listfile)
        }
    }

    $(document).on("change", ".service_images", function(e) {
        var files = e.target.files,
            filesLength = files.length;

        let icount = $(".image-files").find('.upload-list').length + filesLength;

        for (var i = 0; i < filesLength; i++) {
            var f = files[i];
            var Acceptarr = ['image/png', 'image/jpeg', 'image/jpg'];

            if (!Acceptarr.includes(f.type)) {
                var notification = alertify.notify('Please upload valid file', 'error', 6);
                return false;
            }
            var fileReader = new FileReader();

            fileReader.onload = (function(f) {
                return function(e) {

                    var fileName = f.name;
                    var fileType = f.type;
                    var result = e.target.result;


                    var deleteIconSrc = "{{asset('public/images/delete-icon-01.svg')}}";
                    var cfilecontent = '<div class="upload-list"><input type="hidden" name="serviceImages[]" value="' + result + '"> <div class="d-flex align-items-center"> <img class="teamphoto" style="" src="' + result + '" alt=""> <h4 class="ms-2">' + fileName + '</h4> </div> <img class="delete-btn deleteibtn" style="" src="' + deleteIconSrc + '" alt=""> </div>';
                    $(".image-files").append(cfilecontent);
                };
            })(f);


            fileReader.readAsDataURL(f);
        }

        var ctext = ' ' + icount + ' File(s) Uploaded ';
        $('.icount').text(ctext);

        $(this).val('');
    });

    $(document).on("click", ".deleteibtn", function() {
        
        var id = $(this).attr('data-id');
        if(id){
            $('.remove_images').append('<input type="hidden" name="remove_images[]" value="' + id + '">');
        }
        
        $(this).closest('.upload-list').remove();
        let ccount = $(".image-files").find('.upload-list').length;
        var ctext = ' ' + ccount + ' Files Uploaded ';
        $('.icount').text(ctext);
    });

    $(document).on("change", ".service_vedios", function(e) {
        var files = e.target.files,
            filesLength = files.length;

        let vcount = $(".vedio-files").find('.upload-list').length + filesLength;

        for (var i = 0; i < filesLength; i++) {
            var f = files[i];
            var Acceptarr = ['video/mp4'];

            if (!Acceptarr.includes(f.type)) {
                alertify.notify('Please upload only MP4 videos', 'error', 6);
                return false;
            }

            var fileReader = new FileReader();
            fileReader.onload = (function(f) {
                return function(e) {
                    var fileName = f.name;
                    var result = e.target.result;

                    var deleteIconSrc = "{{ asset('public/images/delete-icon-01.svg') }}";

                    var cfilecontent = `
                <div class="upload-list d-flex align-items-center justify-content-between p-2 border mb-2">
                    <input type="hidden" name="serviceVedios[]" value="${result}">
                    <div class="d-flex align-items-center">
                        <video class="video-thumb me-2" src="${result}" controls></video>
                        <span class="file-name">${fileName}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="me-2 mb-0" style="font-size: 14px;">
                            <input type="hidden" name="isPremium[]" value="0" class="premium-hidden">
                            <input type="checkbox" class="form-check-input is-premium" value="1"> Is Premium
                        </label>
                        <input type="number" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control form-control-sm amount-input me-4 d-none" name="amount[]" placeholder="Amount">
                        <img class="delete-btn deletevbtn" src="${deleteIconSrc}" alt="Delete">
                    </div>
                </div>
                `;
                    $(".vedio-files").append(cfilecontent);
                };
            })(f);

            fileReader.readAsDataURL(f);
        }

        $('.vcount').text(vcount + ' File(s) Uploaded');
        $(this).val('');
    });

    $(document).on("click", ".deletevbtn", function() {
        
        var id = $(this).attr('data-id');
        if(id){
            $('.remove_vedios').append('<input type="hidden" name="remove_vedios[]" value="' + id + '">');
        }
        
        $(this).closest('.upload-list').remove();
        let ccount = $(".vedio-files").find('.upload-list').length;
        var ctext = ' ' + ccount + ' Files Uploaded ';
        $('.vcount').text(ctext);
    });

    $(document).on("change", ".is-premium", function() {

        let hiddenInput = $(this).siblings(".premium-hidden");
        hiddenInput.val(this.checked ? "1" : "0");
        if (this.checked) {
            $(this).closest('.align-items-center').find('.amount-input').removeClass('d-none');
            $(this).closest('.align-items-center').find('.amount-input').val('');
        } else {
            $(this).closest('.align-items-center').find('.amount-input').addClass('d-none');
            $(this).closest('.align-items-center').find('.amount-input').val(0);
        }
    });

</script>
@endsection
