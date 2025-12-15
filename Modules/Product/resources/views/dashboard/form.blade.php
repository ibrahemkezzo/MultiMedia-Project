{{-- resources/views/product/dashboard/form.blade.php --}}

@php
    $mode = isset($product) ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Create Product') : __('Edit Product');
    $description = $mode === 'create' ? __('Add a new product to the store') : __('Update product information');
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Products'), 'url' => route('dashboard.products.index')],
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
                    <h5>{{ $title }}</h5>
                </div>
                <div class="card-body">

                    <form action="{{ $mode === 'create' ? route('dashboard.products.store') : route('dashboard.products.update', $product) }}"
                          method="POST" enctype="multipart/form-data"
                          class="needs-validation row" novalidate>
                        @csrf
                        @if ($mode === 'edit')
                            @method('PUT')
                        @endif

                        <x-dashboard::form.input
                            wrapperClass="col-md-6 mb-3"
                            name="name"
                            label="{{ __('Name') }}"
                            value="{{ old('name', $product->name ?? '') }}"
                            required
                        />

                        <x-dashboard::form.select
                            wrapperClass="col-md-6 mb-3"
                            name="category_id"
                            label="{{ __('Category') }}"
                            :options="$categories"
                            selected="{{ old('category_id', $product->category_id ?? '') }}"
                            required
                        />
                        <x-dashboard::form.select
                            wrapperClass="col-md-6 mb-3"
                            name="store_id"
                            label="{{ __('Store') }}"
                            :options="$stores"
                            selected="{{ old('store_id', $product->store_id ?? '') }}"
                            required
                        />

                        <x-dashboard::form.input
                            wrapperClass="col-md-4 mb-3"
                            name="price"
                            label="{{ __('Price') }}"
                            type="number"
                            step="0.01"
                            value="{{ old('price', $product->price ?? '') }}"
                            required
                        />

                        <x-dashboard::form.input
                            wrapperClass="col-md-4 mb-3"
                            name="compare_price"
                            label="{{ __('Compare Price') }}"
                            type="number"
                            step="0.01"
                            value="{{ old('compare_price', $product->compare_price ?? '') }}"
                        />

                        <x-dashboard::form.input
                            wrapperClass="col-md-4 mb-3"
                            name="stock"
                            label="{{ __('Stock') }}"
                            type="number"
                            value="{{ old('stock', $product->stock ?? 0) }}"
                            required
                        />

                        <x-dashboard::form.input
                            wrapperClass="col-md-6 mb-3"
                            name="sku"
                            label="{{ __('SKU') }}"
                            value="{{ old('sku', $product->sku ?? '') }}"
                        />

                        <x-dashboard::form.input
                            wrapperClass="col-md-6 mb-3"
                            name="weight"
                            label="{{ __('Weight (kg)') }}"
                            type="number"
                            step="0.01"
                            value="{{ old('weight', $product->weight ?? '') }}"
                        />

                        <x-dashboard::form.textarea
                            wrapperClass="mb-3"
                            name="short_description"
                            label="{{ __('Short Description') }}"
                            value="{{ old('short_description', $product->short_description ?? '') }}"
                        />

                        <x-dashboard::form.textarea
                            wrapperClass="mb-3"
                            name="description"
                            label="{{ __('Description') }}"
                            value="{{ old('description', $product->description ?? '') }}"
                        />

                        <x-dashboard::form.file-input
                            name="images"
                            label="صور المنتج"
                            multiple
                            accept="image/*"
                            size="xl"
                            color="primary"
                        />

                        {{-- <x-dashboard::form.checkbox-group
                            wrapperClass="col-md-4 mt-4 mb-3"
                            name="is_active"
                            labelItemClass="form-check-label"
                            :options="['1' => __('Active')]"
                            checked="{{ old('is_active', $product->is_active ?? 1) }}"
                        /> --}}
                            {{-- <x-dashboard::form.checkbox-group
                                wrapperClass="col-md-4 col-x-4 mt-4 mb-3 form-check form-switch"
                                inputClass="form-check-input"
                                name="is_active"
                                labelItemClass="form-check-label ms-2"
                                :options="['1' => 'Active']"
                                :checked="{{ old('is_active', $product->is_active ?? 1) }}"
                            /> --}}
                            <x-dashboard::form.checkbox-group
                                wrapperClass="col-md-4 col-x-4 mt-4 mb-3 form-check form-switch"
                                inputClass="form-check-input"
                                name="is_active"
                                labelItemClass="form-check-label ms-2"
                                text="{{ __('Active Category') }}"
                                :options="['1' => 'Active']"
                                checked="{{ old('is_active', $product->is_active ?? 1) }}"
                            />

                        <x-dashboard::form.input
                            wrapperClass="col-md-4 mb-3"
                            name="sort_order"
                            label="{{ __('Sort Order') }}"
                            type="number"
                            value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                        />

                        <div class="d-flex justify-content-end mt-4">
                            <x-dashboard::form.action-link route="dashboard.products.index"
                                class="btn btn-secondary me-2" label="{{ __('Cancel') }}" />
                            <x-dashboard::form.action-button type="submit"
                                label="{{ $mode === 'create' ? __('Create') : __('Update') }}" icon="fa fa-check"
                                buttonClass="btn btn-primary" />
                        </div>
                    </form>

                        @if ($mode === 'edit' && $product->getMedia('gallery')->count())
                            <div class="mb-3">
                                <label class="form-label">{{ __('Current Images') }}</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($product->getMedia('gallery') as $media)
                                        <div class="position-relative">
                                            <img src="{{ $media->getUrl() }}" alt="" class="img-thumbnail" width="150">
                                            <form action="{{ route('dashboard.products.removeImage', $product) }}" method="POST" class="position-absolute top-0 end-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="media_id" value="{{ $media->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
