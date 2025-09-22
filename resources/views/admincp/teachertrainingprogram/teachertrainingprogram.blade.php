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
                    <li class="breadcrumb-item active" aria-current="page"><a>Teacher Training Program Management</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Teacher Training Program Management
                        </div>
                        <div class="text-end">
                            <a class="" href="{{route('addteachertrainingprogram')}}">
                                <button type="button" class="btn btn-primary">Add Teacher Training Program</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="faqDatatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

<!-- Delete modal start -->
<div id="deleteModal" class="modal fade popup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="delete_modal_content">
        </div>
    </div>
</div>
<!-- Delete Modal End -->

<div class="modal fade" id="changeStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="change_status_modal_content">
        </div>
    </div>
</div>
<!-- End::app-content -->
@endsection


@section('javascript')
<script>
    var admin_path = "{{ env('ADMIN_URL') }}";
    var table;
    $(document).ready(function() {
        alertify.set('notifier', 'position', 'top-right');
        table = jQuery('#faqDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                url: "{{ route('getteachertrainingprogram') }}",
                type: "GET",
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
                    "taregts": 1,
                    'data': 'title'
                },
                {
                    "taregts": 2,
                    'data': 'description'
                },
                {
                    "taregts": 3,
                    'data': 'status',
                    "searchable": false,
                    "orderable": false,
                    "render": function(data, type, row) {
                        var status = row.status;
                        var id = row.id;
                        if (status == 'active') {
                            return '<button title="Active" class="btn btn-success waves-effect waves-light" onClick="teacherTrainingProgramStatusChange(' + id + ')">Active</button>';
                        } else {
                            return '<button title="Deactive" class="btn btn-danger waves-effect waves-light" onClick="teacherTrainingProgramStatusChange(' + id + ')">Deactive</button>';
                        }
                    }
                },
                {
                    "taregts": 4,
                    'data': 'id',
                    "searchable": false,
                    "orderable": false,
                    "render": function(data, type, row) {
                        var id = row.id;
                        var out = '';

                        out += '<a title="Edit Teacher Training Program" class="text-info fs-14 lh-1" href="{{url("admincp/editteachertrainingprogram")}}/' + id + '" ><i class="ri-edit-line"></i></a>&nbsp;&nbsp;&nbsp;';
                        out += '<a title="Delete Teacher Training Program" class="text-danger fs-14 lh-1" onClick="deleteTeacherTrainingProgram(' + id + ');"><i class="ri-delete-bin-5-line"></i></a>';
                        return out;
                    }
                },
            ]
        });
        $('#search').on('click', function() {
            table.draw();
        });
        $('.search').on('click', function() {
            table.draw();
        });
        $('.reset').on('click', function() {
            $('.filter-section').find('input').val('');
            $('.filter-section').find('select').val('');
            table.draw();
        });
    });

    function deleteTeacherTrainingProgram(id) {
        $.ajax({
            url: admin_path + 'teachertrainingprogramdeletemodal/' + id,
            success: function(response) {
                if (response.status == 'success') {
                    $('#delete_modal_content').html(response.html);
                    $('#deleteModal').modal('show');
                } else {
                    var notification = alertify.notify(response.message, 'error', 6);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Delete AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

    function teacherTrainingProgramStatusChange(id) {
        $.ajax({
            url: admin_path + 'changeteachertrainingprogramstatusmodal/' + id,
            success: function(response) {
                if (response.status == 'success') {
                    $('#change_status_modal_content').html(response.html);
                    $('#changeStatusModal').modal('show');
                } else {
                    var notification = alertify.notify(response.message, 'error', 6);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Delete AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }

</script>
@endsection
