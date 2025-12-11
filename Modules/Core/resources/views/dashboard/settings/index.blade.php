@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb
        :breadcrumbs="[
            ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
            ['label' => __('Website Settings'), 'url' => '#'],
        ]"
        :pageName="__('Website Settings')"
        :pageDsecript="__('Manage website general configuration')"
    />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card tab2-card">
                <div class="card-body">

                    {{-- TABS --}}
                    <ul class="nav nav-tabs nav-material" id="settingsTabs" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="tab"
                               href="#general" role="tab" aria-controls="general" aria-selected="true">
                                <i class="fa fa-sliders me-2"></i>{{ __('General') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="appearance-tab" data-bs-toggle="tab"
                               href="#appearance" role="tab" aria-controls="appearance" aria-selected="false">
                                <i class="fa fa-paint-brush me-2"></i>{{ __('Appearance') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-bs-toggle="tab"
                               href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                                <i class="fa fa-search me-2"></i>{{ __('SEO') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="email-tab" data-bs-toggle="tab"
                               href="#email" role="tab" aria-controls="email" aria-selected="false">
                                <i class="fa fa-envelope me-2"></i>{{ __('Email Settings') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="payments-tab" data-bs-toggle="tab"
                               href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                                <i class="fa fa-credit-card me-2"></i>{{ __('Payments') }}
                            </a>
                        </li>

                    </ul>

                    {{-- TAB CONTENT --}}
                    <div class="tab-content" id="settingsTabsContent">

                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            @include('core::dashboard.settings.tabs.general')
                        </div>

                        <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                            @include('core::dashboard.settings.tabs.appearance')
                        </div>

                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            @include('core::dashboard.settings.tabs.seo')
                        </div>

                        <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                            @include('core::dashboard.settings.tabs.email')
                        </div>

                        <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                            @include('core::dashboard.settings.tabs.payments')
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
