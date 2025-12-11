@php($s = $settings)
{{-- @dd(setting_get('items_per_page'),$s) --}}
<div class="card">
    <div class="card-header">
        <h5 class="f-w-600">{{ __('General Settings') }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" class="row">
            @csrf

            {{-- SITE NAME / EMAIL / PHONE --}}
            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Site Name') }}"
                name="site_name"
                :value="setting_get('site_name')"
                required
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Site Email') }}"
                type="email"
                name="contact_email"
                :value="setting_get('contact_email')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Phone Number') }}"
                name="contact_phone"
                :value="setting_get('contact_phone')"
            />

            {{-- SITE DESCRIPTION --}}
            <x-dashboard::form.textarea
                wrapperClass="form-group col-md-12"
                label="{{ __('Site Description') }}"
                name="site_description"
                :value="setting_get('site_description')"
                placeholder="{{ __('Describe your website...') }}"
            />

            {{-- DEFAULT CURRENCY / TIMEZONE / LOCALE --}}
            <x-dashboard::form.input
                wrapperClass="form-group col-md-4"
                label="{{ __('Default Currency') }}"
                name="default_currency"
                :value="old('default_currency', $s['default_currency'] ?? 'USD')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-4"
                label="{{ __('Timezone') }}"
                name="timezone"
                :value="old('timezone', $s['timezone'] ?? config('app.timezone'))"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-4"
                label="{{ __('Locale') }}"
                name="locale"
                :value="old('locale', $s['locale'] ?? app()->getLocale())"
            />

            {{-- ITEMS PER PAGE & COMMISSION --}}
            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                type="number"
                label="{{ __('Items per page') }}"
                name="items_per_page"
                :value="old('items_per_page', $s['items_per_page'] ?? 15)"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                type="number"
                step="0.01"
                label="{{ __('Commission rate (%)') }}"
                name="commission_rate"
                :value="old('commission_rate', $s['commission_rate'] ?? 0)"
            />

            {{-- MAINTENANCE MODE --}}
            <div class="col-md-12 mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input"
                        type="checkbox"
                        id="maintenance_mode"
                        name="maintenance_mode"
                        value="1"
                        {{ old('maintenance_mode', $s['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="maintenance_mode">
                        {{ __('Maintenance Mode') }}
                    </label>
                </div>
            </div>

            {{-- SOCIAL MEDIA LINKS --}}
            <div class="col-md-12">
                <h6 class="mb-2 mt-3">{{ __('Social Media Links') }}</h6>
            </div>

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Facebook URL') }}"
                name="social_facebook"
                :value="setting_get('social_facebook')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Instagram URL') }}"
                name="social_instagram"
                :value="setting_get('social_instagram')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('Twitter URL') }}"
                name="social_twitter"
                :value="setting_get('social_twitter')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('TikTok URL') }}"
                name="social_tiktok"
                :value="setting_get('social_tiktok')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="{{ __('YouTube URL') }}"
                name="social_youtube"
                :value="setting_get('social_youtube')"
            />



            {{-- FOOTER TEXT --}}
            <x-dashboard::form.textarea
                wrapperClass="form-group col-md-12"
                label="{{ __('Footer Text') }}"
                name="footer_text"
                :value="setting_get('footer_text')"
                placeholder="{{ __('Footer text displayed at the bottom of the site...') }}"
            />

            {{-- SAVE BUTTON --}}
            <x-dashboard::form.action-button
                type="submit"
                label="{{ __('Save Changes') }}"
                icon="fa fa-check"
                divClass="text-end mt-4"
            />

        </form>
    </div>
</div>
