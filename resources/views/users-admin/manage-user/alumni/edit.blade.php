@empty($alumni)
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
                    <h5><i class="icon fas fa-ban"></i>Failed!!!</h5>
                    Data not found.
                </div>
                <a href="{{ url('/manage-users/alumni') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
    @else
    <form action="{{ url('/manage-users/alumni/' . $alumni->alumni_id.'/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Alumni Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $alumni->name }}" required>
                        <small id="error-name" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                        <small id="error-photo" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Home Address</label>
                        <input type="text" name="home_address" id="home_address" class="form-control" value="{{ $alumni->home_address }}" required>
                        <small id="error-home_address" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Current Address</label>
                        <input type="text" name="current_address" id="current_address" class="form-control" value="{{ $alumni->current_address }}" required>
                        <small id="error-current_address" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-edit').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == true) {
                            $('#myModal').modal('hide');
                            location.reload();
                        } else {
                            $.each(response.errors, function(key, value) {
                                $('#error-' + key).text(value);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endempty
