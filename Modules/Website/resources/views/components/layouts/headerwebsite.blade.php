{{-- Modules/Website/resources/views/components/layouts/headerwebsite.blade.php --}}
<header class="position-fixed top-0 start-0 end-0 bg-white shadow-sm" style="z-index: 1050;">
    <div class="border-bottom">
        <div class="container-fluid" style="max-height: 4rem;">
            <div class="d-flex align-items-center justify-content-between py-1 px-3">
                <div class="logo-box">
                    <a href="{{ route('home') }}">
                        <img src="{{ setting('logo') }}" alt="ShopBook" title="ShopBook" style="height: 40px;">
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Language Dropdown -->
                    <div class="position-relative">
                        <button id="langBtn" class="btn btn-link text-dark p-0" aria-label="Toggle language">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </button>

                        <div id="langMenu" class="position-absolute end-0 mt-2 shadow-sm rounded bg-white border" style="display: none; min-width: 140px; z-index: 1100;">
                            <button class="dropdown-item text-start w-100 px-3 py-2 border-0 bg-transparent" data-lang="en">English</button>
                            <button class="dropdown-item text-start w-100 px-3 py-2 border-0 bg-transparent" data-lang="ar">العربية</button>
                            <button class="dropdown-item text-start w-100 px-3 py-2 border-0 bg-transparent" data-lang="fr">Français</button>
                        </div>
                    </div>

                    <!-- Cart Icon -->
                    <a class="btn btn-link text-dark p-2 position-relative" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                        </svg>
                    </a>

                    <!-- User Profile Dropdown (فقط إذا كان مسجل دخول) -->
                    @auth
                        <div class="position-relative">
                            <button id="profileBtn" class="btn p-0 border-0">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="User avatar"
                                     class="rounded-circle border border-primary border-2" style="width: 36px; height: 36px; object-fit: cover; cursor: pointer;">
                            </button>

                            <div id="profileMenu" class="position-absolute end-0 mt-2 shadow-sm rounded bg-white border" style="display: none; min-width: 180px; z-index: 1100;">
                                <a href="{{ route('profile.show') }}" class="dropdown-item px-3 py-2 text-start">
                                    {{ __('My Profile') }}
                                </a>
                                <hr class="dropdown-divider my-1">
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-start w-100 px-3 py-2 border-0 bg-transparent text-danger">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- إذا غير مسجل دخول -->
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-5">
                            {{ __('Login')  }} / {{ __('Register') }}
                        </a>

                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Navigation -->
    <div class="border-bottom" style="max-height: 4rem;">
        <div class="container-fluid">
            <div class="subnav py-1 d-flex justify-content-center gap-5">
                <a href="{{ route('home') }}" class="subnav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="icon">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" fill="none" stroke-width="2">
                            <path d="M3 11L12 3l9 8"></path>
                            <path d="M5 10v10h14V10"></path>
                        </svg>
                    </span>
                    <span>Home</span>
                </a>

                <a href="{{ route('offers') }}" class="subnav-item {{ request()->routeIs('offers') ? 'active' : '' }}">
                    <span class="icon">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" fill="none" stroke-width="2">
                            <path d="M12 2l3 7h7l-5.5 4.5L18 22l-6-4-6 4 1.5-8.5L2 9h7z"></path>
                        </svg>
                    </span>
                    <span>Offers</span>
                </a>

                <a href="{{ route('stores.index') }}" class="subnav-item {{ request()->routeIs('stores.*') ? 'active' : '' }}">
                    <span class="icon">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" fill="none" stroke-width="2">
                            <path d="M3 7h18l-2 12H5L3 7z"></path>
                            <path d="M7 7V4h10v3"></path>
                        </svg>
                    </span>
                    <span>Stores</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="border-bottom px-3 py-3" style="max-height: 4rem;">
        <div class="d-flex gap-2">
            <div class="position-relative flex-grow-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" class="form-control ps-5" placeholder="Search products, stores..." name="search" value="{{ request('search') }}">
            </div>
            <button id="mapBtn" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map">
                    <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"></path>
                    <path d="M15 5.764v15"></path>
                    <path d="M9 3.236v15"></path>
                </svg>
            </button>
            <button id="filterBtn" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal">
                    <line x1="21" x2="14" y1="4" y2="4"></line>
                    <line x1="10" x2="3" y1="4" y2="4"></line>
                    <line x1="21" x2="12" y1="12" y2="12"></line>
                    <line x1="8" x2="3" y1="12" y2="12"></line>
                    <line x1="21" x2="16" y1="20" y2="20"></line>
                    <line x1="12" x2="3" y1="20" y2="20"></line>
                    <line x1="14" x2="14" y1="2" y2="6"></line>
                    <line x1="8" x2="8" y1="10" y2="14"></line>
                    <line x1="16" x2="16" y1="18" y2="22"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Components -->
    <div class="mobile-filter">
        <x-website::layouts.mobilefilterwebsite />
    </div>
    <div class="mobile-map">
        <x-website::layouts.mobilemapwebsite />
    </div>
</header>
