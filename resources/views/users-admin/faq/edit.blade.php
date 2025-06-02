<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        @if(empty($faqs))
        <div class="modal-header">
            <h5 class="modal-title">Failed</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Failed!!!</h5>
                Data not found.
            </div>
            <a href="{{ url('faqs/') }}" class="btn btn-warning">Back</a>
        </div>
        @else
        <form action="{{ url('faqs/' . $faqs->faq_id. '/update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question', $faqs->question) }}">
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Answer</label>
                    <textarea class="form-control @error('answer') is-invalid @enderror" name="answer">{{ old('answer', $faqs->answer) }}</textarea>
                    @error('answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
        @endif
    </div>
</div>