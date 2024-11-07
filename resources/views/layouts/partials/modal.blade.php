<div class="modal fade" id="confirmDelete{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel{{ $id }}">{{ $text ?? 'Confirm Delete' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fw-normal">
                <p>{{ $name }}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ $deleteRoute }}" method="POST">
                    @csrf
                    @method($method)
                    <button type="submit" class="btn btn-secondary tr-button">Delete</button>
                </form>
                <button type="button" class="btn btn-danger tr-button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
