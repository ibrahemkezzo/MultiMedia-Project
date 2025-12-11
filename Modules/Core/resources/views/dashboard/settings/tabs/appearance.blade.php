@php
    $logo   = setting_get('logo');
    $favicon = setting_get('favicon');
    $banner = setting_get('default_store_banner');
@endphp

<div class="card">
    <div class="card-header">
        <h5 class="f-w-600">{{ __('Appearance Settings') }}</h5>
    </div>

    <div class="card-body">

        {{-- ===========================
            PREVIEW IMAGES SECTION
        ============================ --}}
        <div class="row mb-4">

            {{-- Logo Preview --}}
            @if($logo)
                <div class="col-md-4 col-sm-12 mb-3  text-center ">
                    <div class="border rounded p-3 shadow-sm h-100 ">
                        <h6 class="text-muted mb-3">{{ __('Current Logo') }}</h6>
                        <img src="{{ $logo }}"
                             alt="Logo"
                             class="img-fluid rounded"
                             style="max-height: 150px; object-fit: contain;">
                    </div>
                </div>
            @endif

            {{-- Favicon Preview --}}
            @if($favicon)
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="border rounded p-3 text-center shadow-sm h-100">
                        <h6 class="mb-3 text-muted">{{ __('Current Favicon') }}</h6>
                        <img src="{{ $favicon }}"
                             alt="Favicon"
                             class="img-fluid rounded"
                             style="max-height: 150px; object-fit: contain;">
                    </div>
                </div>
            @endif

            {{-- Banner Preview --}}
            @if($banner)
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="border rounded p-3 text-center shadow-sm h-100">
                        <h6 class="mb-3 text-muted">{{ __('Store Banner') }}</h6>
                        <img src="{{ $banner }}"
                             alt="Store Banner"
                             class="img-fluid rounded"
                             style="max-height: 150px; object-fit: cover; width: 100%;">
                    </div>
                </div>
            @endif

        </div>

        {{-- ===========================
                FORM SECTION
        ============================ --}}
        <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf

            <x-dashboard::form.file-input
                wrapperClass="form-group col-md-6"
                label="{{ __('Logo') }}"
                name="logo"
                :value="$logo"
            />

            <x-dashboard::form.file-input
                wrapperClass="form-group col-md-6"
                label="{{ __('Favicon') }}"
                name="favicon"
                :value="$favicon"
            />

            <x-dashboard::form.file-input
                wrapperClass="form-group col-md-12"
                label="{{ __('Default Store Banner') }}"
                name="default_store_banner"
                :value="$banner"
            />

            <x-dashboard::form.action-button
                type="submit"
                label="{{ __('Save Changes') }}"
                icon="fa fa-check"
                divClass="text-end mt-4"
            />
        </form>
    </div>
</div>
