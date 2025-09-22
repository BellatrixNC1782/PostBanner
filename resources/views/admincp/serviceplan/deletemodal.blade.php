<div class="modal-header">
    <h6 class="modal-title" id="staticBackdropLabel">Delete Service Plan
    </h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="alert alert-danger" style="display:none"></div>
</div>
<form id="edit_setting_form" name="edit_setting_form">
    @csrf
    <input type="hidden" name="id" id="serviceId" value="{{ base64_encode($edit_data->id) }}">
    <div class="modal-body">
        <p>Are you sure you want to delete this service plan?</p>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="deteleSetting()" class="btn btn-primary">Delete</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>

<script>
    alertify.set('notifier', 'position', 'top-right');
    function deteleSetting() {
        var admin_path = "{{ env('ADMIN_URL') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: admin_path + 'deleteserviceplan',
            method: 'post',
            data: {
                serviceId: $('#serviceId').val()
            },
            success: function (data) {
                $('#deleteModal').modal('hide');
                table.draw();
                if (data.status === 'success') {
                    var notification = alertify.notify(data.message, 'success', 3);
                } else {
                    var notification = alertify.notify(data.message, 'error', 3);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var notification = alertify.notify(errorThrown, 'error', 3);
                console.log("Edit Modal AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
</script>
