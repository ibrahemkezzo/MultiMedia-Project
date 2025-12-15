{{-- Modules/Website/resources/views/components/layouts/mobilefilterwebsite.blade.php --}}
<div class="mobile-filter">
    <div id="mobileFilterModal" class="d-none modal" tabindex="-1"
        style="background-color: rgba(0, 0, 0, 0.5); z-index: 1055;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="max-height: 90vh;">
                <div class="modal-header">
                    <h5 class="modal-title">filterProducts</h5>
                    <button type="button" class="btn-close" id="closeMobileFilter"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">categories</label>
                        @foreach ($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input category-radio" type="radio" name="category"
                                    id="modal-cat-{{ $category->slug }}" data-category-id="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="modal-cat-{{ $category->slug }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">subCategories</label>
                        <div id="modal-subcategories-container">
                            @foreach ($subcategories as $subcategory)
                                <div class="form-check mb-2 subcategory-item"
                                    data-parent-id="{{ $subcategory->parent_id }}">
                                    <input class="form-check-input" type="checkbox"
                                        id="modal-subcat-{{ $subcategory->slug }}"
                                        {{ is_array(request('subcategory')) && in_array($subcategory->id, request('subcategory')) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="modal-subcat-{{ $subcategory->slug }}">{{ $subcategory->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">priceRange</label>
                        <div class="row g-2">
                            <div class="col-6"><input type="number" class="form-control" placeholder="Min"
                                    value="0"></div>
                            <div class="col-6"><input type="number" class="form-control" placeholder="Max"
                                    value="1000"></div>
                        </div>
                    </div>
                    <div class="mb-4"><label class="form-label fw-semibold">availability</label>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="inStock"
                                checked=""><label class="form-check-label" for="inStock">inStockOnly</label>
                        </div>
                    </div>
                    <div class="mb-4"><label class="form-label fw-semibold">minimumRating</label><select
                            class="form-select">
                            <option value="0">allRatings</option>
                            <option value="3">3+ stars</option>
                            <option value="4">4+ stars</option>
                            <option value="4.5">4.5+ stars</option>
                        </select></div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->current() }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="button" class="btn btn-primary">applyFilters</button>
                </div>
            </div>
        </div>
    </div>
</div>
