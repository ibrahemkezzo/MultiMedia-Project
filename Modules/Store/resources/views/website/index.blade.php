{{-- Modules/Website/resources/views/stores/index.blade.php --}}
@extends('website::layouts.app')

@section('title', __('All Stores') . ' - ' . setting('site_name'))

@section('content')
    <x-website::layouts.filterwebsite display="d-none" />
    <main id="mainContent" class="px-3 pt-3 my-container">
        <div class="pb-4">
            <div class="bg-white border-bottom px-3 py-3 mb-3">
                <h2 class="h5 fw-bold mb-0">{{ __('All Stores') }}</h2>
            </div>
            <div class="px-3">
                <div class="row ">
                    @foreach ($stores as $store)
                        <x-website::partials.store-card :store="$store" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $stores->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
