{{-- Modules/Website/resources/views/components/partials/store-card.blade.php --}}
<div class="col-6 mb-4">
    <div class="card shadow-sm h-100 border-0 overflow-hidden">
        <a href="{{ route('stores.show', $store) }}" class="text-decoration-none">
            <div class="position-relative" style="height: 128px;">
                    <img src="{{ setting_get('cover_store',"https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=300&fit=crop",$store->id) }}" alt="{{ $store->name }}" class="w-100 h-100" style="object-fit: cover;">



                    <img src="{{ setting_get('logo_store',"https://api.dicebear.com/7.x/initials/svg?seed=".substr($store->name, 0, 2) ,$store->id) }}" alt="{{ $store->name }}"
                         class="position-absolute rounded-circle border border-4 border-white" style="width: 64px; height: 64px; bottom: -32px; left: 16px; object-fit: cover;">

            </div>
        </a>

        <div class="card-body" style="padding-top: 40px;">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <h5 class="card-title h6 fw-bold mb-1 text-dark" >{{ $store->name }}</h5>
                    <div class="d-flex align-items-center gap-1 small text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin">
                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>
                            {{ $store->city ?? 'Unknown' }}, {{ $store->country ?? 'Unknown' }}
                        </span>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary">Follow</button>
            </div>

            <div class="d-flex align-items-center gap-3 small">
                <div class="d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-warning" viewBox="0 0 24 24">
                        <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
                    </svg>
                    <span class="fw-medium">{{ $store->rating ?? 'N/A' }}</span>
                </div>
                {{-- <div>
                    <span class="fw-semibold">{{ $store->followers_count ?? 0 }}</span>
                    <span class="text-muted">Followers</span>
                </div> --}}
                <div>
                    <span class="fw-semibold">{{ $store->products_count ?? 0 }}</span>
                    <span class="text-muted">Products</span>
                </div>
            </div>
        </div>
    </div>
</div>
