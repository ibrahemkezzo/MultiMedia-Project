@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard::dashboardbreadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('Profile'), 'url' => '#'],
    ]" :pageName="__('Profile')" :pageDsecript="__('Manage Profile')" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10">
                <div class="card tab2-card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
                                    href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user me-2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>Profile</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                    href="#top-contact" role="tab" aria-controls="top-contact"
                                    aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-settings me-2">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>Contact</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade active show" id="top-profile" role="tabpanel"
                                aria-labelledby="top-profile-tab">
                                <div class="card">

                                    <div class="card-header">
                                        <h5 class="f-w-600">Profile</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('user-profile-information.update') }}" method="POST"
                                            class="row">
                                            @method('PUT')
                                            @csrf

                                            <x-dashboard::form.input wrapperClass="form-group col-xl-6 col-md-6"
                                                label="{{ __('Name') }}" labelClass="col-form-label pt-0" type="text"
                                                name="name" inputClass="form-control" :value="old('name', $user->name)"
                                                validation-bag="updateProfileInformation" required />

                                            <x-dashboard::form.input wrapperClass="form-group col-xl-6 col-md-6"
                                                label="{{ __('Email') }}" labelClass="col-form-label pt-0" type="text"
                                                name="email" inputClass="form-control" :value="old('email', $user->email)"
                                                validation-bag="updateProfileInformation" required />

                                            <x-dashboard::form.input wrapperClass="form-group"
                                                label="{{ __('Image Profile') }}" labelClass="col-form-label pt-0"
                                                type="file" name="photo" inputClass="form-control"
                                                validation-bag="updateProfileInformation" />

                                            <x-dashboard::form.action-button type="submit" divClass="text-end mt-4"
                                                label="{{ __('Save Changes') }}" icon="fa fa-check"
                                                buttonClass="btn btn-primary" />
                                        </form>
                                    </div>
                                </div>
                                <div class="card">

                                    <div class="card-header">
                                        <h5 class="f-w-600">Update Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('user-password.update') }}" method="POST">
                                            @method('PUT')
                                            @csrf

                                            <x-dashboard::form.input wrapperClass="form-group"
                                                label="{{ __('Current Password') }}" labelClass="col-form-label pt-0"
                                                type="password" name="current_password" inputClass="form-control"
                                                validation-bag="updatePassword" required />
                                            <x-dashboard::form.input wrapperClass="form-group"
                                                label="{{ __('New Password') }}" labelClass="col-form-label pt-0"
                                                type="password" name="password" inputClass="form-control"
                                                :value="old('Password')" validation-bag="updatePassword" required />

                                            <x-dashboard::form.input wrapperClass="form-group"
                                                label="{{ __('Password Confirmation') }}" labelClass="col-form-label pt-0"
                                                type="password" name="password_confirmation" inputClass="form-control"
                                                :value="old('password_confirmation')" validation-bag="updatePassword" required />

                                            <x-dashboard::form.action-button type="submit" divClass="text-end mt-4"
                                                label="{{ __('Update Password') }}" icon="fa fa-check"
                                                buttonClass="btn btn-primary" />
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                aria-labelledby="contact-top-tab">

                                <div class="account-setting deactivate-account">
                                    <h5 class="f-w-600">Deactivate Account</h5>
                                    <div class="row">
                                        <div class="col">
                                            <label class="d-block" for="edo-ani">
                                                <input class="radio_animated" id="edo-ani" type="radio"
                                                    name="rdo-ani" checked="">
                                                I have a privacy concern
                                            </label>
                                            <label class="d-block" for="edo-ani1">
                                                <input class="radio_animated" id="edo-ani1" type="radio"
                                                    name="rdo-ani">
                                                This is temporary
                                            </label>
                                            <label class="d-block mb-0" for="edo-ani2">
                                                <input class="radio_animated" id="edo-ani2" type="radio"
                                                    name="rdo-ani" checked="">
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary">Deactivate
                                        Account</button>
                                </div>
                                <div class="account-setting deactivate-account">
                                    <h5 class="f-w-600">Delete Account</h5>
                                    <div class="row">
                                        <div class="col">
                                            <label class="d-block" for="edo-ani3">
                                                <input class="radio_animated" id="edo-ani3" type="radio"
                                                    name="rdo-ani1" checked="">
                                                No longer usable
                                            </label>
                                            <label class="d-block" for="edo-ani4">
                                                <input class="radio_animated" id="edo-ani4" type="radio"
                                                    name="rdo-ani1">
                                                Want to switch on other account
                                            </label>
                                            <label class="d-block mb-0" for="edo-ani5">
                                                <input class="radio_animated" id="edo-ani5" type="radio"
                                                    name="rdo-ani1" checked="">
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary">Delete Account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
