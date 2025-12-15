{{-- Modules/Website/resources/views/components/partials/product-card.blade.php --}}

<div class="col-md-4 col-lg-4 col-sm-12 mb-2">
    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden product-card">
        <div class="position-relative">
            <a href="{{ route('products.show', $product ) }}">

                @if ($product->images()->first())
                    <img src="{{ $product->images()->first()->getUrl() }}" alt="{{ $product->name }}" class="card-img-top"
                         style="aspect-ratio: 1/1; object-fit: cover;">
                @else
                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                         style="aspect-ratio: 1/1; object-fit: cover;">
                        <i class="fa fa-image text-muted fa-3x"></i>
                    </div>
                @endif
                {{-- نسبة التخفيض إذا كان هناك عرض --}}
                @if ($product->compare_price && $product->compare_price > $product->price)
                    @php
                        $discountPercentage = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                    @endphp
                    <div class="position-absolute top-0 start-5 mt-4" style="margin:3.5rem;">
                        <span class="badge bg-danger fw-bold px-2 py-1" style="font-size: 0.85rem; ">
                            -{{ $discountPercentage }}%
                        </span>
                    </div>
                @endif
            </a>
        </div>

        <div class="card-body d-flex flex-column p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ substr($product->store->name, 0, 2) }}"
                     alt="{{ $product->store->name }}" class="rounded-circle" width="28" height="28">
                <small class="text-muted fw-medium">{{ $product->store->name }}</small>
            </div>

            <h6 class="card-title fw-bold mb-2 text-dark" style="color: red !important;">{{ $product->name }}</h6>

            <div class="d-flex align-items-center gap-1 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="text-warning" viewBox="0 0 24 24">
                    <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                </svg>
                <span class="fw-bold small">4.5</span>
                <span class="text-muted small">(234)</span>
            </div>

            <div class="mt-auto">
                <div class="mb-2">
                    @if ($product->compare_price && $product->compare_price > $product->price)
                        <del class="text-muted small me-2">${{ number_format($product->compare_price, 2) }}</del>
                    @endif
                    <span class="h5 text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm flex-grow-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                        </svg>
                        Add
                    </button>
                    <button class="btn btn-primary btn-sm flex-grow-1">Buy Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
