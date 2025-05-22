@empty($announcements)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Failed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Failed!!!</h5>
                    Data not found.
                </div>
                <a href="{{ url('announcements/') }}" class="btn btn-warning">back</a>
            </div>
        </div>
    </div>
    @else
    <form action="{{ url('announcements/' . $announcements->announcement_id . '/delete_ajax') }}" method="POST" id="form-delete" class="d-inline">
        @csrf
        @method('POST')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Announcements Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Confirm !!!</h5>
                        Are you sure you want to delete this data?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Title :</th>
                            <td class="col-9">{{ $announcements->title }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Content :</th>
                            <td class="col-9">{{ $announcements->content }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Announcement Status :</th>
                            <td class="col-9">{{ $announcements->announcement_status }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Announcement Date :</th>
                            <td class="col-9">{{ $announcements->announcement_date }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </form>
    <script>
    $(document).ready(function() {
        $("#form-delete").validate({
            rules: {},
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataAnnouncements.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    </script>
@endempty