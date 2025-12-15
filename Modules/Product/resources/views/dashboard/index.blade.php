{{-- resources/views/product/dashboard/index.blade.php --}}

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Products'), 'url' => route('dashboard.products.index')],
    ]" :pageName="__('Products')" :pageDsecript="__('Manage Products')" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="mb-0">{{ __('Total Products') }} ({{ $products->total() }})</h5>
                        </div>
                    </div>

                    <div class="card-header">
                        <form method="GET" action="{{ route('dashboard.products.index') }}" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control" placeholder="{{ __('Search product...') }}" value="{{ request('search') }}">
                            <input type="number" name="min_price" class="form-control" placeholder="{{ __('Min Price') }}" value="{{ request('min_price') }}">
                            <input type="number" name="max_price" class="form-control" placeholder="{{ __('Max Price') }}" value="{{ request('max_price') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>

                        <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                            @foreach ([10, 25, 50, 100] as $num)
                                <option value="{{ route('dashboard.products.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                                    {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                                    {{ $num }}
                                </option>
                            @endforeach
                            <option value="{{ route('dashboard.products.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                                {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                {{ __('All') }}
                            </option>
                        </select>

                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary mt-md-0 mt-2">
                            {{ __('Add Product') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Store') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Stock') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>
                                                @if ($product->images()->first())
                                                    <img src="{{ $product->media()->first()->getUrl() }}" alt="{{ $product->name }}" width="60" class="rounded">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                                        <i class="fa fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td><strong>{{ $product->name }}</strong></td>
                                            <td>{{ $product->store->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ number_format($product->price, 2) }} {{ __('SAR') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <x-dashboard::form.action-table :model="$product" resource="dashboard.products" resourcePermissions="products" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                {{ __('No products found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <x-dashboard::partials.pagination-links :model="$products"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
