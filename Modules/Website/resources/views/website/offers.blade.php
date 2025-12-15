{{-- Modules/Website/resources/views/offers.blade.php --}}
@extends('website::layouts.app')

@section('title', __('Offers') . ' - ' . setting('site_name'))

@section('content')
    <x-website::layouts.filterwebsite />

    <main id="mainContent" class="px-3 pt-3 my-container">
        <div class="pb-4">
            <div class="bg-white border-bottom px-3 py-3 mb-3">
                <h2 class="h5 fw-bold mb-0">{{ __('Offers') }}</h2>
            </div>
            <div class="px-3">
                <div class="row g-3 ">
                    @foreach ($products as $product)
                        <x-website::partials.product-card :product="$product" />
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </main>
@endsection

@push('styles')

<style>

</style>
@endpush

@push('scripts')
    <script>
        
    </script>
@endpush
