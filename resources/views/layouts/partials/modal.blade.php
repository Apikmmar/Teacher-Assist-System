<div class="modal fade" id="confirmDelete{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                </div>
                <h5 class="mb-3">{{ $text ?? 'Confirm deletion' }}</h5>
                <p class="text-muted mb-4">{{ $name }}</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form action="{{ $deleteRoute }}" method="POST" class="d-inline">
                        @csrf
                        @method($method)
                        <button type="submit" class="btn btn-danger px-4">
                            {{ $callItem ?? 'Delete' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>