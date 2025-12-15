{{-- Modules/Website/resources/views/components/layouts/filterwebsite.blade.php --}}
<div id="desktopFilterMap" class="desktop-filter-map {{ $display }}" style="max-width: 30%;">
    <div class="ps-3 pe-2 col-lg-4 col-md-4">
        <div class="filter-sidebar" style="position: fixed; top: 14rem; width: calc(30% - 1rem); max-height: calc(-14rem + 100vh); overflow: hidden auto; z-index: 10; scroll-behavior: smooth;">

            <!-- Form الفلتر -->
            <form action="{{ url()->current() }}" method="GET">
                <!-- الحفاظ على البارامترات القديمة (مثل page, search...) -->
                @foreach(request()->except(['category', 'subcategory', 'min_price', 'max_price', 'min_rating', 'in_stock']) as $key => $value)
                    @if(!is_array($value))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <div class="card shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="rounded d-flex align-items-center justify-content-center" style="height: 250px; width: 100%; background-color: rgb(233, 236, 239);">
                            <div class="text-center text-muted">
                                <i class="bi bi-map" style="font-size: 3rem;"></i>
                                <p class="mt-2 mb-0">mapComingSoon</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">categories</h6>
                         
                        @foreach($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input category-radio" type="radio" name="category" id="cat-{{ $category->slug }}" data-category-id="{{ $category->id }}" value="{{ $category->id }}"
                                       {{ request('category') == $category->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat-{{ $category->slug }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">subCategories</h6>
                        <div id="subcategories-container">
                            @foreach($subcategories as $subcategory)
                                <div class="form-check mb-2 subcategory-item" data-parent-id="{{ $subcategory->parent_id }}">
                                    <input class="form-check-input" type="checkbox" name="subcategory[]" id="subcat-{{ $subcategory->slug }}" value="{{ $subcategory->id }}"
                                           {{ is_array(request('subcategory')) && in_array($subcategory->id, request('subcategory')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subcat-{{ $subcategory->slug }}">{{ $subcategory->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">priceRange</h6>
                        <div class="mb-3">
                            <!-- الـ slider (مثال بسيط، يمكن تحسينه بـ Alpine.js أو Radix) -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price', 0) }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price', 1000) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">minimumRating</h6>
                        <select class="form-select" name="min_rating">
                            <option value="0" {{ request('min_rating') == '0' ? 'selected' : '' }}>allRatings</option>
                            <option value="3" {{ request('min_rating') == '3' ? 'selected' : '' }}>3+ stars</option>
                            <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ stars</option>
                            <option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+ stars</option>
                        </select>
                    </div>
                </div>
                <div class="row justify-content-center" style="position:sticky; width:100%; bottom: 10px; z-index: 11;">

                    @if(request()->hasAny(['category', 'subcategory', 'min_price', 'max_price', 'min_rating', 'in_stock']))
                        <a href="{{ url()->current() }}" class="btn btn-secondary col-md-5" >
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary col-md-5" style="margin-left:1rem;">applyFilters</button>
                    @else
                        <button type="submit" class="btn btn-primary col-md-10">applyFilters</button>
                    @endif


                    <!-- زر Apply Filters (ثابت في الأسفل) -->


                    <!-- زر Cancel / Clear Filters -->

                </div>



            </form>
        </div>
    </div>
</div>
