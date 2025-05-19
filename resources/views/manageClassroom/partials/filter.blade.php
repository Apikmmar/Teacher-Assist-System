<div class="modal fade filter-modal" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-funnel me-2"></i>Filter Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('filter_student') }}" method="get">
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
            
                    <!-- Sort by IC -->
                    <div class="mb-4">
                        <label for="idSort" class="form-label fw-medium"><i class="bi bi-sort-numeric-down me-2"></i>Sort by IC</label>
                        <select class="form-select" id="idSort" name="sort_ic">
                            <option value="" selected disabled>Choose order</option>
                            <option value="ASC">Older to Younger</option>
                            <option value="DESC">Younger to Older</option>
                        </select>
                    </div>
            
                    <!-- Status -->
                    <div class="mb-4">
                        <label class="form-label fw-medium"><i class="bi bi-check-circle me-2"></i>Filter by Status</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="status_active" value="active" id="activeStatus">
                            <label class="form-check-label" for="activeStatus">Active</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status_inactive" value="inactive" id="inactiveStatus">
                            <label class="form-check-label" for="inactiveStatus">Inactive</label>
                        </div>
                    </div>
            
                    <!-- Gender -->
                    <div class="mb-4">
                        <label class="form-label fw-medium"><i class="bi bi-gender-ambiguous me-2"></i>Filter by Gender</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="gender_men" value="Men" id="maleGender">
                            <label class="form-check-label" for="maleGender">Men</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="gender_women" value="Women" id="femaleGender">
                            <label class="form-check-label" for="femaleGender">Women</label>
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