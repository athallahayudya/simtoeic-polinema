@empty($student)
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
                <a href="{{ url('/manage-users/student/') }}" class="btn btn-warning">back</a>
            </div>
        </div>
    </div>
    @else
    <form action="{{ url('/manage-users/student/' . $student->student_id . '/delete_ajax') }}" method="POST" id="form-delete" class="d-inline">
        @csrf
        @method('POST')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Student Data</h5>
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
                            <td class="col-9">{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIM :</th>
                            <td class="col-9">{{ $student->nim }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Exam Status :</th>
                            <td class="col-9">{{ $student->user->exam_status }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Study Program :</th>
                            <td class="col-9">{{ $student->study_program }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Major :</th>
                            <td class="col-9">{{ $student->major }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Campus :</th>
                            <td class="col-9">{{ $student->campus }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">KTP Scan :</th>
                            <td class="col-9">{{ $student->ktp_scan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">KTM Scan :</th>
                            <td class="col-9">{{ $student->ktm_scan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Photo :</th>
                            <td class="col-9">{{ $student->photo }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Home Address :</th>
                            <td class="col-9">{{ $student->home_address }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Current Address :</th>
                            <td class="col-9">{{ $student->current_address }}</td>
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
                            dataStudent.ajax.reload();
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