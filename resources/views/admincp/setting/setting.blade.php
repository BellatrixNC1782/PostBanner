@extends('Layouts.appadmin')
@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>Setting Management</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Setting Parameters
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-end mb-2">
                            <a class="" href="{{route('addsetting')}}" >
                                <button type="button" class="btn btn-primary" >Add Setting</button>
                            </a>
                        </div>
                        <table id="settingDatatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Setting Title</th>
                                    <th>Setting Key</th>
                                    <th>Setting Value</th>
                                    <th>Type</th>
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
        table = jQuery('#settingDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                url: "{{ route('getsettinglist') }}",
                type: "GET",
            },
            "columns": [
                {"targets": 0, 'data': 'id', "searchable": false, "orderable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"targets": 1, "data": 'setting_title',
                },
                {"targets": 2, 'data': 'setting_key'
                },
                {"targets": 3, 'data': 'setting_value',
                },
                {"targets": 4, 'data': 'type',
                },
                {"targets": 5, 'data': 'created_at',
                },
                {"taregts": 6,'data': 'id', "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        var type = 'delete';
                        out += '<a title="Edit Setting " class="text-info fs-14 lh-1" href="{{url("admincp/editsetting")}}/' + id + '" ><i class="ri-edit-line"></i></a>';
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
</script>
@endsection
