<div class="card">
    <div class="card-header">
        <h5 class="f-w-600">{{ __('SEO Settings') }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" class="row">
            @csrf

            <x-dashboard::form.input
                wrapperClass="form-group col-md-12"
                label="{{ __('Meta Title') }}"
                name="seo_title"
                :value="setting_get('seo_title')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-12"
                label="{{ __('Meta Description') }}"
                name="seo_description"
                :value="setting_get('seo_description')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-12"
                label="{{ __('Meta Keywords') }}"
                name="seo_keywords"
                :value="setting_get('seo_keywords')"
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
