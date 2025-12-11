{{-- resources/views/category/dashboard/form.blade.php --}}

@php
    $mode = isset($category) ? 'edit' : 'create';
    $title = $mode === 'create' ? __('Create Category') : __('Edit Category');
    $description = $mode === 'create' ? __('Add a new category to the system') : __('Update category information');
    $action =
        $mode === 'create' ? route('dashboard.categories.store') : route('dashboard.categories.update', $category);
    $method = $mode === 'create' ? 'POST' : 'PUT';
@endphp

@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Categories'), 'url' => route('dashboard.categories.index')],
        ['label' => $title, 'url' => '#'],
    ]" :pageName="$title" :pageDsecript="$description" />
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0">

                    <div class="card-header">
                        <h5>{{ isset($category) ? __('Edit Category') : __('Create Category') }}</h5>
                    </div>
                    <div class="card-body ">

                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="needs-validation row"
                            novalidate>
                            @csrf
                            @if ($mode === 'edit')
                                @method('PUT')
                            @endif
                            <x-dashboard::form.input
                                wrapperClass="col-md-4 col-x-4 mb-3"
                                name="name"
                                label="Name"
                                value="{{ old('name', $category->name ?? '') }}"
                                required
                            />

                            <x-dashboard::form.select wrapperClass="col-md-4 col-x-4 mb-3" name="parent_id"
                                label="Parent Category" :options="$parents"
                                selected="{{ old('parent_id', $category->parent_id ?? '') }}" placeholder="{{ __('Select Parent') }}" />

                            <x-dashboard::form.checkbox-group wrapperClass="col-md-4 col-x-4 mt-4 mb-3 form-check form-switch"
                                inputClass="form-check-input" name="is_active" labelItemClass="form-check-label ms-2"
                                text="{{ __('Active Category') }}" :options="['1' => 'Active']"
                                checked="{{ old('is_active', $category->is_active ?? 1) }}" />

                            <x-dashboard::form.input wrapperClass="col-md-6 col-x-6 mb-3" name="icon" label="Icon"
                                value="{{ old('icon', $category->icon ?? '') }}" placeholder="fa fa-category" />

                            <x-dashboard::form.input wrapperClass="col-md-6 col-x-6 mb-3" name="sort_order" type="number"
                                label="Sort Order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" />

                            <x-dashboard::form.file-input name="image" label="Image" accept="image/*" />



                            <x-dashboard::form.textarea wrapperClass="mb-5" name="description" label="Description"
                                value="{{ old('description', $category->description ?? '') }}" />

                            <div class="d-flex justify-content-end mt-4">
                                <x-dashboard::form.action-link
                                    route="dashboard.categories.index"
                                    class="btn btn-secondary me-2 mt-4"
                                    label="Cancel"
                                />
                                <x-dashboard::form.action-button type="submit" divClass="text-end mt-4"
                                    label="{{ isset($category) ? __('Update') : __('Create') }}" icon="fa fa-check"
                                    buttonClass="btn btn-primary" />
                            </div>

                        </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
