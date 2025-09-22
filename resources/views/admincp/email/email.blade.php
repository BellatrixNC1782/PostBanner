@extends('Layouts.appadmin')
@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Email Templates</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Email Templates
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-end mb-2">
                            <a class="" href="{{route('addemail')}}" >
                                <button type="button" class="btn btn-primary" >Add Email</button>
                            </a>
                        </div>
                        <table id="emailDatatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Subject</th>
                                    <th>Alias</th>
                                    <th>Created Date</th>
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
        table = jQuery('#emailDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                url: "{{ route('getemaillist') }}",
                type: "GET",
            },
            "columns": [
                {"targets": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"targets": 1, "data": 'subject',
                },
                {"targets": 2, 'data': 'alias'
                },
                {"targets": 3, 'data': 'created_at',
                },
                {"taregts": 4,'data': 'id', "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        var type = 'delete';
                        out += '<a title="Edit Email " class="text-info fs-14 lh-1" href="{{url("admincp/editemail")}}/' + id + '" ><i class="ri-edit-line"></i></a>&nbsp;&nbsp;&nbsp;';
                        out += '<a title="Delete email" class="text-danger fs-14 lh-1" onClick="changeEmailStatusModal(' + id + ');"><i class="ri-delete-bin-5-line"></i></a>';
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
    function changeEmailStatusModal(id) {
            $.ajax({
            url: admin_path + 'changeemailstatus/' + id,
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
