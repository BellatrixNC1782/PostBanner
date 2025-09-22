@extends('Layouts.appadmin')
@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>CMS Management</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            CMS Management
                        </div>
                        <div class="text-end">
                            <a class="" href="{{route('addcms')}}" >
                                <button type="button" class="btn btn-primary" >Add CMS</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="cmsDatatable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Document Name</th>
                                    <th>Document Type</th>
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

<!-- End::app-content -->
@endsection


@section('javascript')
<script type="text/javascript">
    var admin_path = "{{ env('ADMIN_URL') }}";
    var table;
    $(document).ready(function() {
        alertify.set('notifier', 'position', 'top-right');
        table = jQuery('#cmsDatatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [
                [0, "DESC"]
            ],
            "ajax": {
                url: "{{ route('getcms') }}",
                type: "GET",
            },
            "columns": [
                {"taregts": 0, 'data': 'id', "searchable": false, "orderable": false, class:"remove_sorting",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"taregts": 1, 'data': 'document_name'
                },
                {"taregts": 2, 'data': 'document_type'
                },
               
                {"taregts": 3,'data': 'id', "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var id = row.id;
                        var out = '';
                        out += '<a title="Edit Cms " class="text-info fs-14 lh-1" href="{{url("admincp/editcms")}}/' + id + '" ><i class="ri-edit-line"></i></a>&nbsp;&nbsp;&nbsp;';
                        out += '<a title="Delete Cms" class="text-danger fs-14 lh-1" onClick="deleteCms(' + id + ');"><i class="ri-delete-bin-5-line"></i></a>';
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
       
    });
    function deleteCms(id) {
        $.ajax({
            url: admin_path + 'cmsdeletemodal/' + id,
            success: function (response) {
                if (response.status == 'success') {
                    $('#delete_modal_content').html(response.html);
                    $('#deleteModal').modal('show');
                } else {
                    ShowAlert('danger',response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                ShowAlert('danger',errorThrown);
                console.log("Delete AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
    
 
</script>
@endsection
