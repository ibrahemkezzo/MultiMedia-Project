{{-- resources/views/store/dashboard/form.blade.php --}}

@php
    $mode ??= isset($store) ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Create Store') : __('Edit Store');
    $description = $mode === 'create' ? __('Add a new store to the system') : __('Update store information');
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Stores'), 'url' => route('dashboard.stores.index')],
            ['label' => $title, 'url' => '#'],
        ]"
        :pageName="$title"
        :pageDsecript="$description"
    />
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0">

                    <div class="card-header">
                        <h5>{{ isset($store) ? __('Edit Store') : __('Create Store') }}</h5>
                    </div>
                    <div class="card-body ">

                        <form action="{{ $mode === 'create' ? route('dashboard.stores.store') : route('dashboard.stores.update', $store) }}"
                              method="POST" enctype="multipart/form-data"
                            class="needs-validation row" novalidate>
                            @csrf
                            @if ($mode === 'edit')
                                @method('PUT')
                            @endif
                            <x-dashboard::form.input
                                wrapperClass="col-md-6 col-x-4 mb-3"
                                name="name"
                                label="Name"
                                value="{{ old('name', $store->name ?? '') }}"
                                required
                            />

                            <x-dashboard::form.select
                                wrapperClass="col-md-6   col-x-4 mb-3"
                                name="user_id"
                                label="Owner"
                                :options="$users"
                                selected="{{ old('user_id', $store->user_id ?? '') }}"
                                placeholder="{{ __('Select User') }}"
                                required
                            />
                            <x-dashboard::form.select
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="category_id"
                                label="Category"
                                :options="$categories"
                                selected="{{ old('category_id', $store->category_id ?? '') }}"
                                placeholder="{{ __('Select Category') }}"
                                required
                            />

                            <x-dashboard::form.select
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="status"
                                label="Status"
                                :options="['pending' => 'Pending', 'active' => 'Active', 'suspended' => 'Suspended', 'rejected' => 'Rejected']"
                                selected="{{ old('status', $store->status ?? 'pending') }}"
                                placeholder="{{ __('Select Status') }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="address"
                                label="Address"
                                value="{{ old('address', $store->address ?? '') }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="city"
                                label="City"
                                value="{{ old('city', $store->city ?? '') }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="country"
                                label="Country"
                                value="{{ old('country', $store->country ?? '') }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="phone"
                                label="Phone"
                                value="{{ old('phone', $store->phone ?? '') }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="email"
                                label="Email"
                                type="email"
                                value="{{ old('email', $store->email ?? '') }}"
                            />
                            
                            <x-dashboard::form.input
                                wrapperClass="col-md-6 col-x-6 mb-3"
                                name="balance"
                                label="Balance"
                                type="number"
                                step="0.01"
                                value="{{ old('balance', $store->balance ?? 0.00) }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-6 col-x-6 mb-3"
                                name="total_sales"
                                label="Total Sales"
                                type="number"
                                step="0.01"
                                value="{{ old('total_sales', $store->total_sales ?? 0.00) }}"
                            />

                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="rating"
                                label="Rating"
                                type="number"
                                min="0"
                                max="5"
                                value="{{ old('rating', $store->rating ?? 0) }}"
                            />


                            <x-dashboard::form.textarea
                                wrapperClass="mb-5"
                                name="bio" label="Bio"
                                value="{{ old('bio', $store->bio ?? '') }}"
                             />

                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="border rounded p-3 text-center shadow-sm h-100">
                                    <h6 class="mb-3 text-muted">{{ __('Store Banner') }}</h6>
                                    <img src="{{ setting_get('logo_store',null,$store->id) }}"
                                        alt="Store Banner"
                                        class="img-fluid rounded"
                                        style="max-height: 150px; object-fit: cover; width: 100%;">
                                </div>
                            </div>

                            <x-dashboard::form.file-input
                                wrapperClass="col-md-8 col-sm-12"
                                name="logo_store"
                                label="logo_store"
                                accept="image/*"
                            />

                            <div class="d-flex justify-content-end mt-4">
                                <x-dashboard::form.action-link route="dashboard.stores.index"
                                    class="btn btn-secondary me-2 mt-4" label="Cancel" />
                                <x-dashboard::form.action-button type="submit" divClass="text-end mt-4"
                                    label="{{ isset($store) ? __('Update') : __('Create') }}" icon="fa fa-check"
                                    buttonClass="btn btn-primary" />
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
