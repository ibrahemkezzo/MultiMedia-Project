<div class="card">
    <div class="card-header">
        <h5 class="f-w-600">{{ __('Mail Settings') }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" class="row">
            @csrf 

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="SMTP Host"
                name="smtp_host"
                :value="setting_get('smtp_host')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="SMTP Port"
                name="smtp_port"
                :value="setting_get('smtp_port')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="SMTP Username"
                name="smtp_username"
                :value="setting_get('smtp_username')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="SMTP Password"
                name="smtp_password"
                type="password"
                :value="setting_get('smtp_password')"
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
