@empty($faqs)
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
                <a href="{{ url('faqs/') }}" class="btn btn-warning">back</a>
            </div>
        </div>
    </div>
    @else
    <form action="{{ url('faqs/' . $faqs->faq_id . '/delete_ajax') }}" method="POST" id="form-delete" class="d-inline">
        @csrf
        @method('POST')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Question Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Confirm !!!</h5>
                        Are you sure you want to delete this question?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Question :</th>
                            <td class="col-9">{{ $faqs->question }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Answer :</th>
                            <td class="col-9">{{ $faqs->answer }}</td>
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
                                if (typeof dataFaqs !== 'undefined' && dataFaqs.ajax.reload) {
                                    dataFaqs.ajax.reload(); 
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