@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="__('Permissions')"
        :pageDsecript="__('View and manage all system permissions')"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Permissions'), 'url' => route('dashboard.permissions.index')]
        ]"
    />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h5 class="mb-0">{{ __('Total Permissions') }} ({{ $permissions->total() }})</h5>
                    </div>
                </div>
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('dashboard.permissions.index') }}" class="d-flex">

                        <x-dashboard::form.input name="search" type="text" inputClass="form-control me-2"
                        placeholder="{{ __('Search permissions...') }}" value="{{ request('search') }}" />

                        <x-dashboard::form.action-button
                            type="submit"
                            icon="fa fa-search"
                            buttonClass="btn btn-outline-primary ms-2"
                        />

                    </form>

                    <!-- Per Page -->
                    <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                        @foreach([10, 25, 50, 100] as $num)
                            <option value="{{ route('dashboard.permissions.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                                {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                                {{ $num }}
                            </option>
                        @endforeach
                        <option value="{{ route('dashboard.permissions.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                            {{ request('per_page') == 'all' ? 'selected' : '' }}>
                            {{ __('All') }}
                        </option>
                    </select>


                    <x-dashboard::form.action-link
                        route="dashboard.permissions.create"
                        icon="fa fa-plus"
                        title="Add New Permission"
                        label="Add New Permission"
                        class="btn btn-primary mt-md-0 mt-2"
                    />
                </div>



                <!-- Table -->
                <div class="card-body">
                    <div class="table-responsive table-desi">
                        <table class="table all-package" id="editableTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px; min-width: 40px;">#</th>
                                    <th>{{ __('Permission Name') }}</th>
                                    <th>{{ __('Roles Count') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $loop->index }}</td>
                                        <td data-field="text">
                                            <span class="font-monospace text-primary fw-medium">
                                                {{ $permission->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-info fs-6">
                                                    {{ $permission->roles_count ?? 0 }}
                                                </span>
                                                @if(($permission->roles_count ?? 0) > 0)
                                                    <small class="text-muted">
                                                        {{ __('assigned to roles') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $permission->created_at->format('d/m/Y') }}
                                                <br>
                                                <span class="text-muted small">
                                                    {{ $permission->created_at->diffForHumans() }}
                                                </span>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">

                                                {{--
                                                @if($permission->roles_count == 0)
                                                    <a href="javascript:void(0)" class="text-danger"
                                                        onclick="confirmPermissionDelete({{ $permission->id }}, '{{ addslashes($permission->name) }}')"
                                                        title="{{ __('Delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <form id="delete-permission-form-{{ $permission->id }}"
                                                          action="{{ route('dashboard.permissions.destroy', $permission) }}"
                                                          method="POST" style="display: none;">
                                                        @csrf @method('DELETE')
                                                    </form>
                                                @else
                                                    <span class="text-muted" title="{{ __('Cannot delete: assigned to roles') }}">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                                @endif --}}

                                                <x-dashboard::form.action-table :model="$permission" resource="dashboard.permissions"
                                                    resourcePermissions="permissions" />

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa fa-inbox fa-3x mb-3"></i>
                                            <h5>{{ __('No permissions found') }}</h5>
                                            <a href="{{ route('dashboard.permissions.create') }}" class="btn btn-primary mt-3">
                                                {{ __('Create First Permission') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <x-dashboard::partials.pagination-links :model="$permissions" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enter للبحث
    document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') this.form.submit();
    });
</script>

@endpush
