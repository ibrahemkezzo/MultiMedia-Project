{{-- resources/views/dashboard/users/form.blade.php --}}
@php
    // لو ما وصلناش $mode → نحدده تلقائيًا
    $mode ??= $user->exists ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Create User') : __('Edit User');
    $description = $mode === 'create' ? __('Add a new user to the system') : __('Update user information');
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :pageName="$title"
        :pageDsecript="$description"
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Users'), 'url' => route('dashboard.users.index')],
            ['label' => $title, 'url' => '#']
        ]"
    />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tab2-card">
                <div class="card-body">

                    <form action="{{ $mode === 'create' ? route('dashboard.users.store') : route('dashboard.users.update', $user) }}"
                          method="POST" class="needs-validation" novalidate>
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs tab-coupon mb-4" id="userTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="account-tab" data-bs-toggle="tab" href="#account" role="tab">
                                    <i class="fa fa-user me-2"></i> {{ __('Account Details') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="roles-tab" data-bs-toggle="tab" href="#roles" role="tab">
                                    <i class="fa fa-shield me-2"></i> {{ __('User Roles') }}
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="userTabsContent">

                            <!-- === Account Tab === -->
                            <div class="tab-pane fade show active" id="account" role="tabpanel">
                                <h4 class="mb-4">{{ __('Account Information') }}</h4>

                                <x-dashboard::form.input
                                    wrapperClass="form-group row"
                                    label="{{ __('Name') }}"
                                    labelClass="col-xl-3 col-md-4"
                                    type="text"
                                    name="name"
                                    devClass="col-xl-8 col-md-7"
                                    inputClass="form-control"
                                    :value="old('name', $user->name)"
                                    required
                                />

                                <x-dashboard::form.input
                                    wrapperClass="form-group row"
                                    label="{{ __('Email') }}"
                                    labelClass="col-xl-3 col-md-4"
                                    type="email"
                                    name="email"
                                    devClass="col-xl-8 col-md-7"
                                    inputClass="form-control"
                                    :value="old('email', $user->email)"
                                    required
                                />

                                <x-dashboard::form.input
                                    wrapperClass="form-group row"
                                    label="{{ __('Password') }}"
                                    labelClass="col-xl-3 col-md-4"
                                    type="password"
                                    name="password"
                                    devClass="col-xl-8 col-md-7"
                                    inputClass="form-control"
                                    :required="$mode === 'create'"
                                    autocomplete="new-password"
                                />

                                <x-dashboard::form.input
                                    wrapperClass="form-group row"
                                    label="{{ __('Confirm Password') }}"
                                    labelClass="col-xl-3 col-md-4"
                                    type="password"
                                    name="password_confirmation"
                                    devClass="col-xl-8 col-md-7"
                                    inputClass="form-control"
                                    :required="$mode === 'create'"
                                    autocomplete="new-password"
                                />

                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary next-tab">
                                        <i class="fa fa-arrow-right"></i> {{ __('Next') }}
                                    </button>
                                </div>
                            </div>

                            <!-- === Roles Tab === -->
                            <div class="tab-pane fade" id="roles" role="tabpanel">
                                <h4 class="mb-4">{{ __('Assign Roles') }}</h4>
                                <p class="text-muted mb-4">{{ __('Select one or more roles for this user') }}</p>

                                @if ($roles->count())
                                    <x-dashboard::form.checkbox-group
                                        name="roles"
                                        label="{{ __('Available Roles') }}"
                                        :options="$roles->pluck('name', 'name')->toArray()"
                                        :checked="old('roles', $user->roles->pluck('name')->toArray())"
                                        wrapperClass="row"
                                        itemClass="col-md-4 col-sm-6 mb-3"
                                        inputClass="form-check-input"
                                        labelItemClass="form-check-label fw-medium"
                                    />
                                @else
                                    <div class="alert alert-warning">
                                        {{ __('No roles found. Please create roles first.') }}
                                        <a href="{{ route('dashboard.roles.create') }}" class="alert-link">
                                            {{ __('Create Role') }}
                                        </a>
                                    </div>
                                @endif

                                <hr class="my-5">

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-dark prev-tab">
                                        <i class="fa fa-arrow-left"></i> {{ __('Back to Users') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> {{ $mode === 'create' ? __('Create User') : __('Update User') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nextBtn = document.querySelector('.next-tab');
        const prevBtn = document.querySelector('.prev-tab');

        nextBtn?.addEventListener('click', () => document.querySelector('#roles-tab').click());
        prevBtn?.addEventListener('click', () => document.querySelector('#account-tab').click());
    });
</script>
@endpush
