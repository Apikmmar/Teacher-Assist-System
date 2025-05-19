<div class="modal fade filter-modal" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-funnel me-2"></i>Filter Examination</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('filter_examination') }}" method="get">
                <div class="modal-body">
                    <!-- Sort by Name -->
                    <div class="mb-4">
                        <label for="nameSort" class="form-label fw-medium"><i class="bi bi-sort-alpha-down me-2"></i>Sort by Name</label>
                        <select class="form-select" id="nameSort" name="sort_name">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC">A to Z</option>
                            <option value="DESC">Z to A</option>
                        </select>
                    </div>
            
                    <!-- Sort by Duration -->
                    <div class="mb-4">
                        <label for="durationSort" class="form-label fw-medium"><i class="bi bi-clock-history me-2"></i>Sort by Duration</label>
                        <select class="form-select" id="durationSort" name="sort_duration">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC">Shortest to Longest</option>
                            <option value="DESC">Longest to Shortest</option>
                        </select>
                    </div>

                    <!-- Sort by Release Date -->
                    <div class="mb-4">
                        <label for="releaseSort" class="form-label fw-medium"><i class="bi bi-calendar-date me-2"></i>Sort by Release Date</label>
                        <select class="form-select" id="releaseSort" name="sort_release">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC">Oldest to Newest</option>
                            <option value="DESC">Newest to Oldest</option>
                        </select>
                    </div>
            
                    <!-- Status -->
                    <div class="mb-4">
                        <label class="form-label fw-medium"><i class="bi bi-check-circle me-2"></i>Filter by Status</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="status_release" value="release" id="releaseStatus">
                            <label class="form-check-label" for="releaseStatus">Release</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status_pending" value="pending" id="pendingStatus">
                            <label class="form-check-label" for="pendingStatus">Pending</label>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill me-1"></i>Apply Filters</button>
                </div>
            </form>            
        </div>
    </div>
</div>