@extends('Layouts.appadmin')
@section('content')

<div class="page">
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div class="page-leftheader">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a>Reports</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="profile-cover">
                            <div class="wideget-user-tab">
                                <div class="tab-menu-heading p-0">
                                    <div class="tabs-menu1 px-3 border-top">
                                        <ul class="nav">
                                            <li><a href="{{route('purchasevideoreport')}}" class="fs-14">Purchase Video Report</a></li>
                                            <li><a href="{{route('subscriptionreport')}}" class="active fs-14">Subscription Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-xl-2 col-lg-4 col-sm-4">
                                    <div class="form-group mb-3">
                                        <label>Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                            <input type="text" class="form-control start_date" id="date" placeholder="Choose start date" name="start_date" readonly="readonly" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-sm-4">
                                    <div class="form-group mb-3">
                                        <label>End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                            <input type="text" class="form-control end_date" id="date" placeholder="Choose end date" name="end_date" readonly="readonly" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 mt-3">
                                    <button class="btn btn-primary me-2 search" type="submit" name="search">Search</button>
                                    <button class="btn btn-danger reset" type="reset" name="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="subscription_datatable" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Plan Name</th>
                                        <th>Duration</th>
                                        <th>Amount ($)</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="changeStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="change_status_modal_content">
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    var admin_path = "{{ env('ADMIN_URL') }}";
    var table;

    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function(e, s, data) {
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function(e, settings) {
                if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                }
                dt.one('preXhr', function(e, s, data) {
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                setTimeout(dt.ajax.reload, 0);
                return false;
            });
        });
        dt.ajax.reload();
    }
    $(document).ready(function() {
        alertify.set('notifier', 'position', 'top-right');
        table = jQuery('#subscription_datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                action: newexportaction,
                title: 'Anjana Yoga - Subscription Report',
                text: 'EXCEL',
            }, ],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                url: "<?php echo route('getsubscriptionreport'); ?>",
                type: "GET",
                data: function(d) {
                    d.start_date = $('.start_date').val();
                    d.end_date = $('.end_date').val();
                },
            },
            "columns": [{
                    "targets": 0,
                    'data': 'id',
                    "searchable": false,
                    "orderable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": 1,
                    'data': 'user_name'
                },
                {
                    "targets": 2,
                    "data": 'email'
                },
                {
                    "targets": 3,
                    "data": 'name'
                },
                {
                    "targets": 4,
                    'data': 'duration_type'
                },
                {
                    "targets": 5,
                    'data': 'amount'
                },
                {
                    "targets": 6,
                    'data': 'created_at'
                },
                {
                    "targets": 7,
                    'data': 'end_date'
                },

            ],
        });

        $('#search').on('click', function() {
            table.draw();
        });
        $('.search').on('click', function() {
            start_date = $('.start_date').val();
            end_date = $('.end_date').val();
            // Check if either start_date or end_date is empty
            if (start_date === '' && end_date !== '') {
                var notification = alertify.notify('Start date is required', 'error', 6);
                return false;
            }

            if (start_date !== '' && end_date === '') {
                var notification = alertify.notify('End date is required', 'error', 6);
                return false;
            }

            if (new Date(end_date) < new Date(start_date)) {
                var notification = alertify.notify('End date must be greater then start date', 'error', 6);
                return false;
            }
            table.draw(true);
        });
        $('.reset').on('click', function() {
            $('.filter-section').find('input').val('');
            $('.filter-section').find('select').val('');
            table.draw();
        });
    });

    flatpickr(".start_date, .end_date", {
        dateFormat: "m-d-Y",
        maxDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                instance.input.value = dateStr;
            }
        },
        onReady: function(selectedDates, dateStr, instance) {
            var today = instance.todayDateObj;
            if (today) {
                var todayElem = instance.days.querySelector('.flatpickr-day.today');
                if (todayElem) {
                    todayElem.style.backgroundColor = 'transparent';
                    todayElem.style.border = '2px solid #007bff';
                }
            }
        }
    });

</script>
@endsection
