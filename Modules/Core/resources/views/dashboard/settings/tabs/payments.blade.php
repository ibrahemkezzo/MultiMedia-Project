<div class="card">
    <div class="card-header">
        <h5 class="f-w-600">{{ __('Payment Settings') }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" class="row">
            @csrf 

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="Stripe Public Key"
                name="stripe_public"
                :value="setting_get('stripe_public')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-6"
                label="Stripe Secret Key"
                name="stripe_secret"
                type="password"
                :value="setting_get('stripe_secret')"
            />

            <x-dashboard::form.input
                wrapperClass="form-group col-md-12"
                label="Commission Rate (%)"
                name="commission_rate"
                type="number"
                :value="setting_get('commission_rate', 10)"
                required
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
