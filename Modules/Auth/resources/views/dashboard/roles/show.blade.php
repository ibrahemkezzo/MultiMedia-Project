{{-- resources/views/auth/dashboard/roles/show.blade.php --}}
@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="__('Role Details')"
        :pageDsecript="__('View role permissions and assigned users')"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
            ['label' => $role->name, 'url' => '#']
        ]"
    />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa fa-shield-alt me-3"></i>
                        {{ $role->name }}
                    </h4>
                    <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> {{ __('Edit') }}
                    </a>
                </div>

                <div class="card-body p-5">
                    <!-- Role Info -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-lg bg-primary text-white rounded-circle">
                                        <i class="fa fa-shield-alt fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h5 class="mb-1">{{ $role->name }}</h5>
                                    <small class="text-muted">
                                        {{ __('Created at') }} {{ $role->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="badge bg-primary fs-5 px-4 py-3">
                                <i class="fa fa-users me-2"></i>
                                {{ $role->users_count }} {{ __('Users') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <!-- Permissions -->
                    <h5 class="mb-4 text-primary">
                        <i class="fa fa-key me-2"></i> {{ __('Permissions') }}
                        <span class="badge bg-primary ms-2">{{ $role->permissions->count() }}</span>
                    </h5>

                    @if($role->permissions->count())
                        <div class="row">
                            @foreach($role->permissions as $permission)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <code class="text-success">
                                            {{ Str::title(str_replace('-', ' ', $permission->name)) }}
                                        </code>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            {{ __('No permissions assigned to this role') }}
                        </div>
                    @endif

                    <hr class="my-5">

                    <!-- Assigned Users -->
                    <h5 class="mb-4 text-primary">
                        <i class="fa fa-users me-2"></i> {{ __('Users with this role') }}
                    </h5>

                    @if($role->users->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Last Login') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-3">
                                                        <img src="{{ $user->profile_photo_url ?? asset('images/avatar.png') }}"
                                                             alt="{{ $user->name }}" class="rounded-circle">
                                                    </div>
                                                    <strong>{{ $user->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $user->last_login_at?->diffForHumans() ?? __('Never') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fa fa-users fa-3x mb-3 opacity-25"></i>
                            <p>{{ __('No users assigned to this role yet') }}</p>
                        </div>
                    @endif

                    <div class="mt-5 text-center">
                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fa fa-arrow-left"></i> {{ __('Back to Roles') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
