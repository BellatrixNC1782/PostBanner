@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Workshop Management</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Workshop Management
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-end mb-2">
                            <a class="" href="{{route('addworkshop')}}" >
                                <button type="button" class="btn btn-primary" >Add Workshop</button>
                            </a>
                        </div>
                        <table id="workshopDatatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Created Date</th>
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

<!-- modal start -->
<div class="modal fade" id="changeStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="change_status_modal_content">
        </div>
    </div>
</div>
<!-- Modal End -->
@endsection

@section('javascript')
<script>
    var admin_path = "{{ env('ADMIN_URL') }}";
    var table;
    $(document).ready(function () {

        alertify.set('notifier', 'position', 'top-right');
        table = jQuery('#workshopDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[0, "DESC"]],
            "ajax": {
                url: admin_path + 'getworkshop',
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'title'
                },
                {"taregts": 2, 'data': 'date',
                },
                {"taregts": 3, 'data': 'from_time'
                },
                {"taregts": 4, 'data': 'to_time'
                },
                {"taregts": 5, 'data': 'created_at'
                },
                {"taregts": 6, 'data': 'status', "searchable": false,
                    "render": function (data, type, row) {
                        var status = row.status;
                        var id = row.id;
                        var i_status = row.workshop_status;
                        var out = '';
                        var type = 'status';
                        if(i_status != 'Completed') {
                            if (status == "active") {
                                out += '<button title="Active" class="btn btn-success waves-effect waves-light" onClick="changeWorkshopStatusModal(' + id + ', \'' + type + '\')">Active</button>&nbsp;&nbsp;&nbsp;';
                            } else {
                                out += '<button title="Inactive" class="btn btn-danger waves-effect waves-light" onClick="changeWorkshopStatusModal(' + id + ', \'' + type + '\')">Inactive</button>&nbsp;&nbsp;&nbsp;';
                            }                            
                        } else {
                            if (status == "active") {
                                out += '<button title="Active" class="btn btn-success waves-effect waves-light" disabled onClick="changeWorkshopStatusModal(' + id + ', \'' + type + '\')">Active</button>&nbsp;&nbsp;&nbsp;';
                            } else {
                                out += '<button title="Inactive" class="btn btn-danger waves-effect waves-light" disabled onClick="changeWorkshopStatusModal(' + id + ', \'' + type + '\')">Inactive</button>&nbsp;&nbsp;&nbsp;';
                            }
                        }
                        return out;
                    }
                },
                {"taregts": 7, 'data': 'id', "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        var type = 'delete';
                        if (!row.is_started) {
                            out += '<a title="Edit Workshop " class="text-info fs-14 lh-1" href="{{url("admincp/editworkshop")}}/' + id + '" ><i class="ri-edit-line"></i></a>&nbsp;&nbsp;&nbsp;';
                            out += '<a title="Delete Workshop" class="text-danger fs-14 lh-1" onClick="changeWorkshopStatusModal(' + id + ', \'' + type + '\');"><i class="ri-delete-bin-5-line"></i></a>';
                        } else {
                            out += '-';
                        }
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
    
    function changeWorkshopStatusModal(id, type) {
        $.ajax({
            url: admin_path + 'changeworkshopstatusmodal/' + id + '/' +type,
            success: function (response) {
                if (response.status == 'success') {
                    $('#change_status_modal_content').html(response.html);
                    $('#changeStatusModal').modal('show');
                } else {
                    var notification = alertify.notify(response.message, 'error', 6);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Edit Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }    
</script>
@endsection
