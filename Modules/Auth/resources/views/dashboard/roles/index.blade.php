@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :pageName="__('Roles')" :pageDsecript="__('View and manage all system roles')" :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
    ]" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="mb-0">{{ __('Total Roles') }} ({{ $roles->total() }})</h5>
                        </div>
                    </div>
                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('dashboard.roles.index') }}" class="d-flex">

                            <x-dashboard::form.input name="search" type="text" inputClass="form-control me-2"
                                placeholder="{{ __('Search roles...') }}" value="{{ request('search') }}" />

                            <x-dashboard::form.action-button type="submit" icon="fa fa-search"
                                buttonClass="btn btn-outline-primary ms-2" />

                        </form>

                        <!-- Per Page -->
                        <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                            @foreach ([10, 25, 50, 100] as $num)
                                <option
                                    value="{{ route('dashboard.roles.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                                    {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                                    {{ $num }}
                                </option>
                            @endforeach
                            <option
                                value="{{ route('dashboard.roles.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                                {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                {{ __('All') }}
                            </option>
                        </select>


                        <x-dashboard::form.action-link route="dashboard.roles.create" icon="fa fa-plus"
                            title="Add New Permission" label="Add New Permission" class="btn btn-primary mt-md-0 mt-2" />
                    </div>

                    <!-- Table -->
                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package" id="editableTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px; min-width: 20px;">#</th>
                                        <th>{{ __('Role Name') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                        <th>{{ __('Users Count') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th class="text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td data-field="text">
                                                {{ $role->name }}
                                            </td>
                                            <td>
                                                @if ($role->permissions->count())
                                                    <span class="text-success font-medium">
                                                        {{ $role->permissions->count() }} {{ __('permissions') }}
                                                    </span>
                                                    <div class="mt-1">
                                                        @foreach ($role->permissions->take(2) as $permission)
                                                            <span class="badge bg-light text-dark border me-1 mb-1">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                        @if ($role->permissions->count() > 2)
                                                            <span
                                                                class="text-muted small">+{{ $role->permissions->count() - 2 }}
                                                                {{ __('more') }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">{{ __('No permissions') }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-info fs-6">
                                                        {{ $role->users_count }}
                                                    </span>
                                                    @if ($role->users_count > 0)
                                                        <a href="{{ route('dashboard.roles.show', $role) }}"
                                                            class="text-decoration-underline small">
                                                            {{ __('View users') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $role->created_at->format('d/m/Y') }}

                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">

                                                    <x-dashboard::form.action-table :model="$role"
                                                        resource="dashboard.roles" resourcePermissions="roles" />

                                                    {{-- @can('delete-roles')
                                                        @if ($role->name !== 'super-admin' && $role->users_count == 0)
                                                            <a href="javascript:void(0)" class="text-danger"
                                                                onclick="confirmRoleDelete({{ $role->id }}, '{{ addslashes($role->name) }}')"
                                                                title="{{ __('Delete') }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            <!-- الفورم المخفي -->
                                                            <form id="delete-form-{{ $role->id }}"
                                                                action="{{ route('dashboard.roles.destroy', $role) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @else
                                                            <a href="#" title="{{ __('Edit') }}">
                                                                <i class="fa fa-lock"></i>
                                                            </a>
                                                        @endif
                                                    @endcan --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa fa-inbox fa-3x mb-3"></i>
                                                <h5>{{ __('No roles found') }}</h5>
                                                @can('create roles')
                                                    <a href="{{ route('dashboard.roles.create') }}"
                                                        class="btn btn-primary mt-3">
                                                        {{ __('Create First Role') }}
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <x-dashboard::partials.pagination-links :model="$roles" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Optional: Live Search (if you want AJAX later)
        document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // للـ Roles
        function confirmRoleDelete(id, name) {
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                html: `<strong>{{ __('You are about to delete the role') }}:</strong><br>
                   <span class="text-danger fw-bold">${name}</span><br><br>
                   {{ __('This action cannot be undone!') }}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `<i class="fa fa-trash"></i> {{ __('Yes, delete it!') }}`,
                cancelButtonText: `<i class="fa fa-ban"></i> {{ __('Cancel') }}`,
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
