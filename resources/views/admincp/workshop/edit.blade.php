@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('workshop') }}">Workshop Management </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Edit Workshop</a></li>
                </ol>
            </div>
        </div>        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit Workshop
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="edit_workshop" name="edit_workshop" action="{{ route('updateworkshop') }}" enctype="multipart/form-data">
                            <input type="hidden" name="workshop_id" value="{{base64_encode($workshop->id)}}">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{ old('title', $workshop->title) }}" placeholder="Enter workshop title">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                                        <input type="text" class="form-control workshop_date" id="date"
                                               name="date" readonly="readonly"
                                               value="{{ \Carbon\Carbon::parse($workshop->date)->format('m-d-Y') }}">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="from_time" class="form-label">From Time<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="from_time" name="from_time"
                                           value="{{ \Carbon\Carbon::parse($workshop->from_time)->format('H:i') }}">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="to_time" class="form-label">To Time<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="to_time" name="to_time"
                                           value="{{ \Carbon\Carbon::parse($workshop->to_time)->format('H:i') }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
$(document).ready(function () {
    // Flatpickr for workshop date
    $(".workshop_date").flatpickr({
        enableTime: false,
        dateFormat: "m-d-Y",
        defaultDate: "{{ \Carbon\Carbon::parse($workshop->date)->format('m-d-Y') }}"
    });

    // jQuery validation
    $("#edit_workshop").validate({
        rules: {
            title: { required: true },
            date: { required: true },
            from_time: { required: true },
            to_time: { 
                required: true,
                greaterThanTime: "#from_time"
            },
            description: { required: true }
        },
        messages: {
            title: "Please enter workshop title",
            date: "Please select a date",
            from_time: "Please select start time",
            to_time: {
                required: "Please select end time",
                greaterThanTime: "End time must be greater than start time"
            },
            description: "Please enter description"
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.closest('.input-group').length) {
                element.closest('.input-group').after(error);
            } else {
                error.appendTo(element.parent());
            }
        },
        submitHandler: function (form) {
            // Convert date to Y-m-d before submit
            const dateStr = $(".workshop_date").val();
            if (dateStr) {
                const [month, day, year] = dateStr.split('-');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'date',
                    value: `${year}-${month}-${day}`
                }).appendTo(form);
            }
            form.submit();
        }
    });

    // Custom validator for time comparison
    $.validator.addMethod("greaterThanTime", function(value, element, param) {
        const fromTime = $(param).val();
        return fromTime && value > fromTime;
    }, "End time must be greater than start time");
});
</script>
@endsection
