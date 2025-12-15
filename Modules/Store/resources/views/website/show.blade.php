{{-- Modules/Website/resources/views/stores/show.blade.php --}}
@extends('website::layouts.app')

@section('title', $store->name . ' - ' . setting('site_name'))

@section('content')

    <x-website::layouts.filterwebsite />

    <main id="mainContent" class="px-3 pt-3 my-container">
        <div class="pb-4">
            <!-- Back Button -->
            <div class="bg-white border-bottom px-3 py-3 mb-3">
                <a href="{{route('stores.index') }}" class="btn btn-link text-dark p-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-chevron-left">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>

            <!-- Store Cover & Logo -->
            <div class="position-relative" style="height: 200px;">
                    <img src="{{ setting_get('cover_store',"https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=300&fit=crop",$store->id) }}" alt="{{ $store->name }}" class="w-100 h-100" style="object-fit: cover;">

                    <img src="{{ setting_get('logo_store',"https://api.dicebear.com/7.x/initials/svg?seed=".substr($store->name, 0, 2) ,$store->id) }}"
                         class="position-absolute rounded-circle border border-4 border-white" style="width: 100px; height: 100px; bottom: -50px; left: 50%; transform: translateX(-50%); object-fit: cover;">

            </div>

            <!-- Store Info -->
            <div class="px-3 text-center" style="padding-top: 60px;">
                <h2 class="h4 fw-bold mb-1">{{ $store->name }}</h2>
                <div class="d-flex align-items-center justify-content-center gap-1 small text-muted mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-map-pin">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>{{ $store->city ?? 'Unknown' }}, {{ $store->country ?? 'Unknown' }}</span>
                </div>
                <p class="text-muted mb-3">{{ $store->bio ?? 'Your one-stop shop for amazing products.' }}</p>
            </div>

            <!-- Stats -->
            <div class="d-flex align-items-center justify-content-center gap-4 mb-3">
                <div class="text-center">
                    <div class="d-flex align-items-center gap-1 justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="text-warning" viewBox="0 0 24 24">
                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
                        </svg>
                        <span class="fw-bold">{{ number_format($store->rating ?? 0, 1) }}</span>
                    </div>
                    <span class="small text-muted">Rating</span>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ number_format($store->followers_count ?? 0) }}</div>
                    <span class="small text-muted">Followers</span>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ $store->products_count ?? 0 }}</div>
                    <span class="small text-muted">Products</span>
                </div>
            </div>

            <!-- Follow Button -->
            <div class="px-3 mb-4">
                <button class="btn btn-primary w-100">Follow</button>
            </div>

            <!-- Products Section -->
            <div class="px-3">
                <h3 class="h5 fw-bold mb-3">{{ __('Products') }}</h3>
                <div class="row g-3">
                    @forelse ($products as $product)
                            <x-website::partials.product-card :product="$product" />
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">{{ __('No products available yet.') }}</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
