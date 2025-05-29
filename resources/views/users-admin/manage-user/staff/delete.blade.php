@empty($staff)
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
                <a href="{{ url('/manage-users/staff/') }}" class="btn btn-warning">back</a>
            </div>
        </div>
    </div>
    @else
    <form action="{{ url('/manage-users/staff/' . $staff->staff_id . '/delete_ajax') }}" method="POST" id="form-delete" class="d-inline">
        @csrf
        @method('POST')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Staff Data</h5>
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
                            <th class="text-right col-3">Name :</th>
                            <td class="col-9">{{ $staff->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIP :</th>
                            <td class="col-9">{{ $staff->nip }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Exam Status :</th>
                            <td class="col-9">{{ $staff->user->exam_status }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">KTP Scan :</th>
                            <td class="col-9">{{ $staff->ktp_scan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Photo :</th>
                            <td class="col-9">{{ $staff->photo }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Home Address :</th>
                            <td class="col-9">{{ $staff->home_address }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Current Address :</th>
                            <td class="col-9">{{ $staff->current_address }}</td>
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
            $('#form-delete').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST', 
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === true) {
                            $('#modal-master').modal('hide'); 
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                if (typeof dataStaff !== 'undefined' && dataStaff.ajax.reload) {
                                    dataStaff.ajax.reload(); 
                                } else {
                                    location.reload(); 
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request.'
                        });
                    }
                });
            });
        });
    </script>
@endempty