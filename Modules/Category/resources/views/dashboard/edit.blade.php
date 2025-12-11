@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Categories'), 'url' => route('dashboard.categories.index')],
        ['label' => __('Categories Update'), 'url' => '#'],
    ]" :pageName="__('Categories')" :pageDsecript="__('Manage Categories')" />
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

                        @include('category::dashboard._form')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
