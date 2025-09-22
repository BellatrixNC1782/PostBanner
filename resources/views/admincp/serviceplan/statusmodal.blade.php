<div class="modal-header">
    <h6 class="modal-title" id="staticBackdropLabel">Change Status
    </h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="edit_setting_form" name="edit_setting_form">
    @csrf
    <input type="hidden" name="serviceId" id="serviceId" value="{{ base64_encode($edit_data->id) }}">
    <div class="modal-body">
        <p>Are you sure you want to <?php if ($edit_data->status == 'active') {
                                            echo 'Inactive';
                                        } else echo 'Active'; ?> this service plan?</p>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="changeStatusModal()" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>
<script>
    alertify.set('notifier', 'position', 'top-right');

    function changeStatusModal(data) {
        var admin_path = "{{ env('ADMIN_URL') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: admin_path + 'updatserviceplanstatus',
            method: 'post',
            data: {
                 serviceId: $('#serviceId').val(),
            },
            success: function(data) {
                $('#changeStatusModal').modal('hide');
                table.draw();
                if (data.status === 'success') {
                    var notification = alertify.notify(data.message, 'success', 6);
                } else {
                    var notification = alertify.notify(data.message, 'error', 6);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 6);
                console.log("Status Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>
