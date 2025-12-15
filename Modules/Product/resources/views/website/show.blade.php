{{-- Modules/Website/resources/views/product/show.blade.php --}}
@extends('website::layouts.app')

@section('title', $product->name . ' - ' . setting('site_name'))

@section('content')
{{-- <x-website::layouts.filterwebsite/> --}}
    <main id="mainContent" class="px-3 pt-3 my-container pb-5 ">
        <div class="container">
            <!-- Back Button -->
            <div class="bg-white border-bottom px-3 py-3">
                <a href="{{ url()->previous() }}" class="btn btn-link text-dark p-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-left">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>

            <div class="row g-4">
                <!-- Left: Images Gallery -->
                <div class="col-lg-6 mb-5">
                    <div class="sticky-top" style="top: 100px;">
                        <!-- Main Image -->
                        <div class="mb-3 rounded overflow-hidden shadow-sm">
                            @if ($product->images()->first())
                                <img src="{{ $product->images()->first()->getUrl() }}"
                                    alt="{{ $product->name }}" class="img-fluid w-100" id="mainImage"
                                    style="aspect-ratio: 1/1; object-fit: contain; background:#f8f9fa; height:350px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 500px;">
                                    <i class="fa fa-image text-muted fa-5x"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Thumbnails -->
                        @if ($product->images()->count() > 1)
                            <div class="d-flex gap-2 flex-wrap justify-content-center product-image-gallery">
                                @foreach ($product->images() as $index => $media)
                                    <img src="{{ $media->getUrl() }}"
                                        alt="thumb {{ $index + 1 }}"
                                        class="rounded border {{ $index === 0 ? 'border-primary thumbnail-active' : 'border-secondary' }} cursor-pointer"
                                        width="80" height="80"
                                        onclick="changeImage(this, '{{ $media->getUrl() }}')"
                                        style="object-fit: cover;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Product Details -->
                <div class="col-lg-6">
                    <div class="bg-white rounded shadow-sm p-4">
                        <!-- Store Info -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ setting_get('logo_store', 'https://api.dicebear.com/7.x/initials/svg?seed=' . substr($product->store->name, 0, 2), $product->store->id) }}"
                                    alt="{{ $product->store->name }}" alt="{{ $product->store->name }}" class="rounded-circle"
                                    width="50" height="50">

                                <div>
                                    <a href="{{ route('stores.show', $product->store) }}"
                                        class="text-dark text-decoration-none">
                                        <h5 class="mb-0 fw-bold">{{ $product->store->name }}</h5>
                                    </a>
                                    <small class="text-muted">{{ $product->store->category->name ?? 'General' }} • Verified
                                        Seller</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                                </svg>
                            </button>
                        </div>

                        <h1 class="h3 fw-bold mb-3">{{ $product->name }}</h1>

                        <!-- Rating -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="{{ $i <= floor($product->rating ?? 0) ? '#ffc107' : 'none' }}"
                                        stroke="#ffc107" viewBox="0 0 24 24">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="fw-bold">{{ number_format($product->rating ?? 0, 1) }}</span>
                            <span class="text-muted">(234 reviews)</span>
                        </div>

                        <!-- Price with Discount -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <h2 class="text-primary fw-bold mb-0">${{ number_format($product->price, 2) }}</h2>
                                @if ($product->compare_price && $product->compare_price > $product->price)
                                    @php
                                        $discount = round(
                                            (($product->compare_price - $product->price) / $product->compare_price) *
                                                100,
                                        );
                                    @endphp
                                    <del class="text-muted h4 mb-0">${{ number_format($product->compare_price, 2) }}</del>
                                    <span class="badge bg-danger fs-6">{{ $discount }}% OFF</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="badge bg-success fs-6">In Stock ({{ $product->stock }})</span>
                        </div>

                        <hr>

                        <!-- Short Description -->
                        @if ($product->short_description)
                            <p class="text-muted mb-4">{{ $product->short_description }}</p>
                        @endif

                        <!-- Full Description -->
                        <h6 class="fw-bold mb-3">{{ __('Description') }}</h6>
                        <p class="text-muted mb-4">{!! nl2br(e($product->description)) !!}</p>

                        <!-- Specifications Table -->
                        <h6 class="fw-bold mb-3">{{ __('Specifications') }}</h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted">Brand</td>
                                    <td>AudioPro</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">SKU</td>
                                    <td>{{ $product->sku ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Weight</td>
                                    <td>{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Dimensions</td>
                                    <td>{{ $product->dimensions ? implode(' x ', $product->dimensions) . ' cm' : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <small class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                Free delivery on orders above $50
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-5">
                    <h3 class="h5 fw-bold mb-4">{{ __('Related Products') }}</h3>
                    <div class="row g-3">
                        @foreach ($relatedProducts as $related)
                                <x-website::partials.product-card :product="$related" />

                        @endforeach
                    </div>
                </div>
            @endif
        </div>

     {{-- Fixed Bottom Bar المعدل - أزرار عائمة على اليمين، شفافة، صغيرة، ومتجاوبة مع الموبايل --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 10000; pointer-events: none;">
    <div class="d-flex flex-column gap-2" style="pointer-events: auto;">
        <!-- Add to Cart Button -->
        <button class="btn btn-outline-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 2px solid #0d6efd;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="8" cy="21" r="1" />
                <circle cx="19" cy="21" r="1" />
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
            </svg>
        </button>

        <!-- Buy Now Button -->
        <button class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                style="width: 56px; height: 56px; background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(10px);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                <line x1="2" x2="22" y1="10" y2="10"></line>
            </svg>
        </button>
    </div>
</div>
    </main>
@endsection

@push('scripts')
    <script>
        lucide.createIcons();

        function changeImage(thumb, largeSrc) {
            const main = document.getElementById('mainImage');
            main.src = largeSrc || thumb.src.replace(/w=\d+/, 'w=800');

            // Update active thumbnail
            document.querySelectorAll('.product-image-gallery img').forEach(img => {
                img.classList.remove('border-primary', 'thumbnail-active');
                img.classList.add('border-secondary');
            });
            thumb.classList.add('border-primary', 'thumbnail-active');
            thumb.classList.remove('border-secondary');
        }
    </script>
@endpush
