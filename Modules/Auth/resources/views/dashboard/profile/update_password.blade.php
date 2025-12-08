 <div class="card">

     <div class="card-header">
         <h5 class="f-w-600">Update Password</h5>
     </div>
     <div class="card-body">
         <form action="{{ route('user-password.update') }}" method="POST">
             @method('PUT')
             @csrf

             <x-dashboard::form.input wrapperClass="form-group" label="{{ __('Current Password') }}"
                 labelClass="col-form-label pt-0" type="password" name="current_password" inputClass="form-control"
                 validation-bag="updatePassword" required />
             <x-dashboard::form.input wrapperClass="form-group" label="{{ __('New Password') }}"
                 labelClass="col-form-label pt-0" type="password" name="password" inputClass="form-control"
                 :value="old('Password')" validation-bag="updatePassword" required />

             <x-dashboard::form.input wrapperClass="form-group" label="{{ __('Password Confirmation') }}"
                 labelClass="col-form-label pt-0" type="password" name="password_confirmation" inputClass="form-control"
                 :value="old('password_confirmation')" validation-bag="updatePassword" required />

             <x-dashboard::form.action-button type="submit" divClass="text-end mt-4"
                 label="{{ __('Update Password') }}" icon="fa fa-check" buttonClass="btn btn-primary" />
         </form>
     </div>
 </div>
