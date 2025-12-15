@extends('website::layouts.app')
@section('title', setting('site_name'))

@section('content')
    <x-website::layouts.filterwebsite />

    <main id="mainContent" class="px-3 pt-3 my-container">
        <div class="pb-4">
            <div class="bg-white border-bottom px-3 py-3 mb-3">
                <h2 class="h5 fw-bold mb-0">All Products</h2>
            </div>
            <div class="px-3">
                <div class="row g-3 ">
                    @foreach ($products as $product)
                        <x-website::partials.product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
