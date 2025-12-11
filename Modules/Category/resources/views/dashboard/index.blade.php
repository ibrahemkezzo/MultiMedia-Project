@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Categories'), 'url' => route('dashboard.categories.index')],
    ]" :pageName="__('Categories')" :pageDsecript="__('Manage Categories')" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="mb-0">{{ __('Total Categories') }} ({{ $categories->total() }})</h5>
                        </div>
                    </div>

                    <div class="card-header">
                        <form method="GET" action="{{ route('dashboard.categories.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="{{ __('Search category...') }}" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>

                        <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                            @foreach ([10, 25, 50, 100] as $num)
                                <option value="{{ route('dashboard.categories.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                                    {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                                    {{ $num }}
                                </option>
                            @endforeach
                            <option value="{{ route('dashboard.categories.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                                {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                {{ __('All') }}
                            </option>
                        </select>

                        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary mt-md-0 mt-2">
                            {{ __('Add Category') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package table-category table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Parent') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Sort Order') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>
                                                @if ($category->image)
                                                    <img src="{{ asset($category->image) }}" alt="" class="img-fluid" width="50">
                                                @else
                                                    <i class="fa fa-image"></i>
                                                @endif
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                                            <td>
                                                <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $category->sort_order }}</td>
                                            <td>
                                                <x-dashboard::form.action-table :model="$category" resource="dashboard.categories" resourcePermissions="categories" />
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('No categories found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection
