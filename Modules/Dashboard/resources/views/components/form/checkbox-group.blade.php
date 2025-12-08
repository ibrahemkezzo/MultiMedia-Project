@props([
    'name'           => null,
    'label'          => null,
    'options'        => [],
    'checked'        => [],
    'inline'         => false,
    'labelClass'     => 'form-label fw-semibold',
    'wrapperClass'   => 'mb-3',
    'itemClass'      => 'form-check',
    'inputClass'     => 'form-check-input',
    'labelItemClass' => 'form-check-label',
    'required'       => false,
    'disabled'       => false,
    'helpText'       => null,
    'helpTextClass'  => 'text-muted small',
])

@php
    $checkedValues = is_array(old($name)) ? old($name) : (old($name) ? [old($name)] : (array)$checked);
    $itemClasses = $inline ? "$itemClass form-check-inline" : $itemClass;
@endphp

<div class="{{ $wrapperClass }}">
    @if($label)
        <div class="{{ $labelClass }}">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </div>
    @endif

    <div class="options">
        @foreach($options as $value => $text)
            <div class="{{ $itemClasses }}">
                <input
                    type="checkbox"
                    name="{{ $name }}[]"
                    value="{{ $value }}"
                    id="{{ $name }}_{{ $loop->iteration }}"
                    {{ $attributes->except(['class']) }}
                    class="{{ $inputClass }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
                    @checked(in_array($value, $checkedValues))
                    @if($disabled) disabled @endif
                >
                <label class="{{ $labelItemClass }}" for="{{ $name }}_{{ $loop->iteration }}">
                    {{ $text }}
                </label>
            </div>
        @endforeach
    </div>

    @if($helpText)
        <div class="{{ $helpTextClass }}">{{ $helpText }}</div>
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

{{-- =====================================================================
     شرح طريقة الاستخدام + أمثلة عملية
     ===================================================================== --}}

{{--
    أمثلة على الاستخدام:

    1. تشيك بوكس عادي:
       <x-dashboard::form.checkbox-group
           name="hobbies"
           label="الهوايات"
           :options="['read' => 'القراءة', 'sport' => 'الرياضة', 'travel' => 'السفر']" />

    2. متعدد الاختيار في سطر واحد:
       <x-dashboard::form.checkbox-group
           name="notifications"
           label="إشعارات"
           :options="$notificationTypes"
           inline
           :checked="['email', 'sms']" />

    3. مع Livewire وتحديث فوري:
       <x-dashboard::form.checkbox-group
           name="permissions[]"
           label="الصلاحيات"
           :options="$allPermissions"
           :checked="$role->permissions->pluck('id')->toArray()"
           wire:model.live="selectedPermissions" />

    4. تشيك بوكس واحد فقط (مثل الموافقة):
       <x-dashboard::form.checkbox-group
           name="terms"
           :options="['1' => 'أوافق على الشروط والأحكام']"
           required
           help-text="يجب الموافقة للمتابعة" />

    5. كلاسات مخصصة (مثل switch أو كبير):
       <x-dashboard::form.checkbox-group
           name="features"
           :options="$features"
           item-class="form-check form-switch"
           input-class="form-check-input form-check-input-lg" />
--}}
