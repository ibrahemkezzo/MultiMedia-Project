{{-- resources/views/auth/dashboard/permissions/show.blade.php --}}
@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="__('Permission Details')"
        :pageDsecript="__('View permission details and assigned roles')"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Permissions'), 'url' => route('dashboard.permissions.index')],
            ['label' => $permission->name, 'url' => '#']
        ]"
    />
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center py-4">
                    <h4 class="mb-0">
                        <i class="fa fa-key me-3"></i>
                        {{ Str::title(str_replace('-', ' ', $permission->name)) }}
                    </h4>
                    <div>
                        <a href="{{ route('dashboard.permissions.edit', $permission) }}"
                           class="btn btn-warning btn-sm me-2">
                            <i class="fa fa-edit"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('dashboard.permissions.index') }}"
                           class="btn btn-light btn-sm">
                            <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Permission Info -->
                    <div class="row mb-5">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-xl bg-danger text-white rounded-circle">
                                        <i class="fa fa-key fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h3 class="mb-1">{{ Str::title(str_replace('-', ' ', $permission->name)) }}</h3>
                                    <code class="text-muted fs-5">{{ $permission->name }}</code>
                                    <p class="text-muted mt-2">
                                        <small>
                                            <i class="fa fa-calendar me-1"></i>
                                            {{ __('Created at') }} {{ $permission->created_at->format('d M Y, h:i A') }}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-4 mt-md-0">
                            <div class="badge bg-danger fs-5 px-4 py-3">
                                <i class="fa fa-shield-alt me-2"></i>
                                {{ $permission->roles_count }} {{ __('Roles') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <!-- Assigned Roles -->
                    <h4 class="mb-4 text-primary">
                        <i class="fa fa-shield-alt me-2"></i>
                        {{ __('Roles with this permission') }}
                    </h4>

                    @if($permission->roles->count())
                        <div class="row g-4">
                            @foreach($permission->roles as $role)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body text-center py-4">
                                            <div class="avatar avatar-lg bg-primary text-white rounded-circle mx-auto mb-3">
                                                <i class="fa fa-shield-alt fa-lg"></i>
                                            </div>
                                            <h6 class="mb-2 fw-bold">{{ $role->name }}</h6>
                                            <p class="text-muted small mb-3">
                                                {{ $role->users_count }} {{ __('users') }}
                                            </p>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dashboard.roles.show', $role) }}"
                                                   class="btn btn-outline-info btn-sm" title="{{ __('View Role') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.roles.edit', $role) }}"
                                                   class="btn btn-outline-warning btn-sm" title="{{ __('Edit Role') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-ban fa-4x text-muted opacity-25 mb-4"></i>
                            <h5 class="text-muted">{{ __('This permission is not assigned to any role yet') }}</h5>
                        </div>
                    @endif

                    <div class="mt-5 text-center">
                        <a href="{{ route('dashboard.permissions.index') }}"
                           class="btn btn-outline-primary btn-lg">
                            <i class="fa fa-arrow-left me-2"></i>
                            {{ __('Back to Permissions') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
