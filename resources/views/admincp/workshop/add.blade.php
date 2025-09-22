@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('workshop') }}">Workshop Management </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Add Workshop</a></li>
                </ol>
            </div>
        </div>        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Add Workshop
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="add_workshop" name="add_workshop" action="{{route('saveworkshop')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">     
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Please enter title">
                                </div>                     
                                <div class="col-xl-6">
                                    <label class="form-label">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                                        <input type="text" class="form-control workshop_date" name="date"
                                               value="{{ old('date') }}" placeholder="Choose date" readonly>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label">From Time<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="from_time" name="from_time" value="{{ old('from_time') }}">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label">To Time<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="to_time" value="{{ old('to_time') }}">
                                </div>

                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{route('workshop')}}" class="btn btn-danger">Cancel</a>
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
    $(document).ready(function () {

        $(".workshop_date").flatpickr({
            dateFormat: "m-d-Y",
            minDate: "today"
        });

        $("#add_workshop").validate({
            rules: {
                title: { required: true },
                date: { required: true },
                from_time: { required: true },
                to_time: {
                    required: true,
                    greaterThan: "#from_time"
                },
            },
            messages: {
                title: { required: "Please enter title" },
                date: { required: "Please select date" },
                from_time: { required: "Please select start time" },
                to_time: {
                    required: "Please select to time",
                    greaterThan: "To time must be greater than start time"
                }
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

        jQuery.validator.addMethod("greaterThan", function(value, element, param) {
            var fromTime = $(param).val();
            if (!fromTime || !value) return true;
            return value > fromTime;
        }, "End time must be greater than start time");

    });
</script>
@endsection
