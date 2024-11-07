<div class="modal fade filter-modal" id="filterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-right">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Examination</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="get">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nameSort" class="form-label">Sort by Name</label>
                        <select class="form-select" id="nameSort" name="sort_name">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC" >A to Z</option>
                            <option value="DESC" >Z to A</option>
                        </select>
                    </div>
            
                    <hr>
            
                    <div class="mb-3">
                        <label for="idSort" class="form-label">Sort by Duration</label>
                        <select class="form-select" id="idSort" name="sort_duration">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC" >Longest to Shortest</option>
                            <option value="DESC" >Shortest to Longest</option>
                        </select>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="idSort" class="form-label">Sort by Release Date</label>
                        <select class="form-select" id="idSort" name="sort_release">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC">Oldest to Newest</option>
                            <option value="DESC">Newest to Oldest</option>
                        </select>
                    </div>
            
                    <hr>
            
                    <div class="mb-3">
                        <label class="form-label">Filter by Status</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="status_release" value="release" id="releaseStatus">
                            <label class="form-check-label" for="releaseStatus">Release</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status_pending" value="pending" id="pendingStatus">
                            <label class="form-check-label" for="pendingStatus">Pending</label>
                        </div>
                    </div>
            
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>            
        </div>
    </div>
</div>
