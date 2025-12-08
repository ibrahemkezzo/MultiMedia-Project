@extends('dashboard::layouts.app')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[['label' => __('Dashboard'), 'url' => route('dashboard.index')]]" :pageName="__('Dashboard')" />
@endsection
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/dropzone.css') }}">
    @endpush
@endsection
