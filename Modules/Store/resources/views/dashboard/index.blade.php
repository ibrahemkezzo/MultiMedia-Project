{{-- resources/views/store/dashboard/index.blade.php --}}

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Stores'), 'url' => route('dashboard.stores.index')],
    ]" :pageName="__('Stores')" :pageDsecript="__('Manage Stores')" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="mb-0">{{ __('Total Stores') }} ({{ $stores->total() }})</h5>
                        </div>
                    </div>

                    <div class="card-header">
                        <form method="GET" action="{{ route('dashboard.stores.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                placeholder="{{ __('Search store...') }}" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>

                        <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                            @foreach ([10, 25, 50, 100] as $num)
                                <option
                                    value="{{ route('dashboard.stores.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                                    {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                                    {{ $num }}
                                </option>
                            @endforeach
                            <option
                                value="{{ route('dashboard.stores.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                                {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                {{ __('All') }}
                            </option>
                        </select>

                        <a href="{{ route('dashboard.stores.create') }}" class="btn btn-primary mt-md-0 mt-2">
                            {{ __('Add Store') }}
                        </a>
                    </div>

                    <div class="card-header">
                        {{-- داخل card-header بعد البحث --}}

                        <div class="d-flex gap-3 flex-wrap">
                            <form method="GET" action="{{ route('dashboard.stores.index') }}"
                                class="d-flex gap-2 flex-wrap">

                                <select name="city" class="form-select" style="width: 180px;">
                                    <option value="">-- {{ __('All Cities') }} --</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city }}"
                                            {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>

                                <select name="country" class="form-select" style="width: 180px;">
                                    <option value="">-- {{ __('All Countries') }} --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}"
                                            {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-filter"></i> {{ __('Filter') }}
                                </button>

                                @if (request()->hasAny(['search', 'city', 'country']))
                                    <a href="{{ route('dashboard.stores.index') }}" class="btn btn-outline-secondary">
                                        {{ __('Clear') }}
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package table-category table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Owner') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Balance') }}</th>
                                        <th>{{ __('Total Sales') }}</th>
                                        <th>{{ __('Rating') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($stores as $store)
                                        <tr>
                                            <td>{{ $store->id }}</td>
                                            <td>{{ $store->name }}</td>
                                            <td>{{ $store->user->name }}</td>
                                            <td>{{ $store->category->name }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $store->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $store->status }}
                                                </span>
                                            </td>
                                            <td>{{ $store->balance }}</td>
                                            <td>{{ $store->total_sales }}</td>
                                            <td>{{ $store->rating }}</td>
                                            <td>
                                                <x-dashboard::form.action-table :model="$store"
                                                    resource="dashboard.stores" resourcePermissions="stores" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">{{ __('No stores found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                            <x-dashboard::partials.pagination-links :model="$stores"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
