<form action="#" method="post" id="addStatus">
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Add status/progress of the lead</label>
                <input type="text" name="remark" class="form-control">
                <input type="hidden" name="lead_id" value="{{$lead_id}}"/>
            </div>
        </div>

        <div class="col-md-3">
            <button class="btn btn-success" type="submit" style="margin-top: 27px;">Create New</button>
        </div>

        <div class="col-md-12">
            <span class="status-success success-message"></span>
            <span class="status-error error-message"></span>
        </div>
    </div>
</form>

<table class="table table-bordered" id="statuses">
    <thead class="thead-light">
        <tr>
            <th>S.no.</th>
            <th>Status</th>
            <th>Added On</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($progress as $key => $value)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->remark}}</td>
            <td>{{$value->created_at}}</td>
            <td><button class="btn btn-danger btn-sm" type="button" onclick="deleteStatus({{$value->id}})"><i class="fa fa-trash"></i></button></td>
        </tr>
        @empty
            <tr>
                <td class="text-center" colspan="3">No Status Added</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
    $("#addStatus").submit(function(e) {
        e.preventDefault();
        $(".status-success").text('');
        $(".status-error").text('');

        $.ajax({
            url: base_url+'/admin/create-lead-status',
            method: "post",
            data: $(this).serialize(),
            dataType: "json",
            error: function(data) {
                var object = JSON.parse(data.responseText);
                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".status-error").text(value.remark ?? '');
                    });
                } else {
                    $(".status-error").text(object.message);
                }
            },
            success: function(data) {
                $(".status-success").text(data.message);
                $("#statuses tbody").html(data.data);
                $('input[name=remark]').val('');
            }
        });
    });

    function deleteStatus(id) {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this progress?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: base_url+'/admin/delete-lead-status/'+id,
                    dataType: 'json',
                    error: function (xhr, exception, thrownError) {
                        // console.log(thrownError);
                        swal("Something went wrong", {
                            icon: "error",
                            title: "Error",
                        });
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            triggerStatus('{{$lead_id}}');
                            swal("Progress deleted!", {
                                icon: "success",
                                title: "Success",
                            });
                        }
                    }
                });
            }
        });
    }
</script>