{{-- resources/views/auth/dashboard/permissions/form.blade.php --}}
@php
    $mode ??= $permission->exists ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Add New Permission') : __('Edit Permission');
    $description = $mode === 'create'
        ? __('Create a new permission that can be assigned to roles')
        : __('Update permission name');
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="$title"
        :pageDsecript="$description"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Permissions'), 'url' => route('dashboard.permissions.index')],
            ['label' => $title, 'url' => '#']
        ]"
    />
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-7">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-danger py-4 text-center">
                    <h3 class="mb-0 font-primary">
                        <i class="fa fa-key fa-lg me-3"></i>
                        {{ $title }}
                    </h3>
                </div>

                <div class="card-body p-5">
                    <form action="{{ $mode === 'create' ? route('dashboard.permissions.store') : route('dashboard.permissions.update', $permission) }}"
                          method="POST" class="needs-validation" novalidate>
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        <div class="mb-5">
                            <x-dashboard::form.input
                                name="name"
                                label="{{ __('Permission Name') }}"
                                type="text"
                                :value="old('name', $permission->name)"
                                placeholder="e.g. create-users, edit-posts, delete-comments"
                                required
                                inputClass="form-control-lg"

                            />
                        </div>

                        @if($mode === 'edit')
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle me-2"></i>
                                {{ __('This permission is currently assigned to') }}
                                <strong>{{ $permission->roles_count }}</strong>
                                {{ $permission->roles_count == 1 ? __('role') : __('roles') }}
                            </div>
                        @endif

                        <hr class="my-5 border-secondary">

                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <a href="{{ route('dashboard.permissions.index') }}"
                               class="btn btn-outline-secondary btn-lg px-5 order-md-1 order-2">
                                <i class="fa fa-arrow-left me-2"></i>
                                {{ __('Back to Permissions') }}
                            </a>

                            <button type="submit"
                                    class="btn {{ $mode === 'create' ? 'btn-success' : 'btn-primary' }} btn-lg px-5 order-md-2 order-1">
                                <i class="fa {{ $mode === 'create' ? 'fa-plus' : 'fa-save' }} me-2"></i>
                                {{ $mode === 'create' ? __('Create Permission') : __('Update Permission') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
