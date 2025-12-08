{{-- resources/views/auth/dashboard/roles/form.blade.php --}}
@php
    $mode ??= $role->exists ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Add New Role') : __('Edit Role');
    $description = $mode === 'create' ? __('Create a new role and assign permissions') : __('Update role name and permissions');
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="$title"
        :pageDsecript="$description"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Roles'), 'url' => route('dashboard.roles.index')],
            ['label' => $title, 'url' => '#']
        ]"
    />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0">
                <div class="card-header ">
                    <h4 class="mb-0 font-primary">
                        {{ $title }}
                    </h4>
                </div>

                <div class="card-body p-5">
                    <form action="{{ $mode === 'create' ? route('dashboard.roles.store') : route('dashboard.roles.update', $role) }}"
                          method="POST" class="needs-validation" novalidate>
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        <!-- Role Name -->
                        <div class="mb-4">
                            <x-dashboard::form.input
                                name="name"
                                label="{{ __('Role Name') }}"
                                type="text"
                                :value="old('name', $role->name)"
                                placeholder="e.g. Admin, Editor, Moderator"
                                required
                                inputClass="form-control-lg"
                            />
                        </div>

                        <!-- Permissions -->
                        <div class="mt-5">
                            <h5 class="mb-3 text-primary">
                                <i class="fa fa-key me-2"></i>
                                {{ __('Assign Permissions') }}
                            </h5>
                            <p class="text-muted mb-4">
                                {{ __('Select the permissions this role should have') }}
                            </p>

                            @if($permissions->count())
                                <x-dashboard::form.checkbox-group
                                    name="permissions"
                                    label="{{ __('Permissions List') }}"
                                    :options="$permissions->pluck('name', 'name')->map(fn($name) => Str::title(str_replace('-', ' ', $name)))->toArray()"
                                    :checked="old('permissions', $role->permissions->pluck('name')->toArray())"
                                    wrapperClass="row g-4"
                                    itemClass="col-lg-4 col-md-6"
                                    inputClass="form-check-input rounded"
                                    labelItemClass="form-check-label fw-medium text-dark"
                                    helpText="{{ __('You can select multiple permissions') }}"
                                />
                            @else
                                <div class="alert alert-info">
                                    {{ __('No permissions found. Create permissions first.') }}
                                    <a href="{{ route('dashboard.permissions.create') }}" class="alert-link">
                                        {{ __('Create Permission') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <hr class="my-5">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline-dark prev-tab">
                                <i class="fa fa-arrow-left"></i> {{ __('Back to Roles') }}
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>
                                {{ $mode === 'create' ? __('Create Role') : __('Update Role') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
