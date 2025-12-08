@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Users'), 'url' => route('dashboard.users.index')],
    ]" :pageName="__('Users')" :pageDsecript="__('Manage Users')" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">

            <div class="card-header">
                <div>
                    <h5 class="mb-0">{{ __('Total Users') }} ({{ $users->total() }})</h5>
                </div>
            </div>
            <div class="card-header">
                <!-- Search Form -->
                <form method="GET" action="{{ route('dashboard.users.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="{{ __('Search user...') }}"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <select onchange="window.location.href=this.value" class="form-select" style="width: auto;">
                    @foreach ([10, 25, 50, 100] as $num)
                        <option
                            value="{{ route('dashboard.roles.index', array_merge(request()->query(), ['per_page' => $num])) }}"
                            {{ request('per_page', 25) == $num ? 'selected' : '' }}>
                            {{ $num }}
                        </option>
                    @endforeach
                    <option
                        value="{{ route('dashboard.roles.index', array_merge(request()->query(), ['per_page' => 'all'])) }}"
                        {{ request('per_page') == 'all' ? 'selected' : '' }}>
                        {{ __('All') }}
                    </option>
                </select>

                <a href="{{ Route('dashboard.users.create') }}"
                    class="btn btn-primary mt-md-0 mt-2">{{ __('Create User') }}</a>
            </div>

            <div class="card-body">
                <div class="table-responsive table-desi">
                    <table class="all-package coupon-table table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Image Profile') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Last Login') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr data-row-id="1">
                                    <td>
                                        {{ $user->id }}
                                    </td>

                                    <td>
                                        @if (isset($user->profile_photo_path))
                                            <img src="{{ asset($user->profile_photo_path) }}" alt="">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-users font-danger">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                            </svg>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('dashboard.users.show', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        @if ($user->is_online)
                                            <span class="flex w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                            <span class="text-green-600 font-medium">متصل الآن</span>
                                        @else
                                            <span class="flex w-3 h-3 bg-gray-400 rounded-full"></span>
                                            <span class="text-gray-600">
                                                {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'غير مسجل' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->roles->isNotEmpty())
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($user->roles as $role)
                                                    <span>
                                                        {{ Str::ucfirst($role->name) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">لا يوجد دور</span>
                                        @endif
                                    </td>

                                    <td>

                                        {{-- <x-dashboard::form.action-link type="show" route="dashboard.users.show" :model="$user"/>

                                        <x-dashboard::form.action-link type="edit" route="dashboard.users.edit" :model="$user"/>

                                        <x-dashboard::form.action-delete :model="$user" route="dashboard.users.destroy"
                                        /> --}}

                                        <x-dashboard::form.action-table :model="$user" resource="dashboard.users"
                                            resourcePermissions="users" />
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/dropzone.css') }}">
@endpush
