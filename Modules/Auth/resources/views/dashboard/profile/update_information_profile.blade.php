<div class="card">

    <div class="card-header">
        <h5 class="f-w-600">Profile</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('user-profile-information.update') }}" method="POST" class="row">
            @method('PUT')
            @csrf

            <x-dashboard::form.input wrapperClass="form-group col-xl-6 col-md-6" label="{{ __('Name') }}"
                labelClass="col-form-label pt-0" type="text" name="name" inputClass="form-control"
                :value="old('name', $user->name)" validation-bag="updateProfileInformation" required />

            <x-dashboard::form.input wrapperClass="form-group col-xl-6 col-md-6" label="{{ __('Email') }}"
                labelClass="col-form-label pt-0" type="text" name="email" inputClass="form-control"
                :value="old('email', $user->email)" validation-bag="updateProfileInformation" required />

            <x-dashboard::form.input wrapperClass="form-group" label="{{ __('Image Profile') }}"
                labelClass="col-form-label pt-0" type="file" name="photo" inputClass="form-control"
                validation-bag="updateProfileInformation" />

            <x-dashboard::form.action-button type="submit" divClass="text-end mt-4" label="{{ __('Save Changes') }}"
                icon="fa fa-check" buttonClass="btn btn-primary" />
        </form>
    </div>
</div>
