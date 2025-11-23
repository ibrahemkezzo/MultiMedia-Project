@props([
    'name'           => null,
    'label'          => null,
    'options'        => [],
    'checked'        => '',
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
    $checkedValue = old($name, $checked);
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
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    id="{{ $name }}_{{ $value }}"
                    {{ $attributes->except(['class']) }}
                    class="{{ $inputClass }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
                    @checked($checkedValue == $value)
                    @if($disabled) disabled @endif
                    @if($required) required @endif
                >
                <label class="{{ $labelItemClass }}" for="{{ $name }}_{{ $value }}">
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

    1. راديو عادي عمودي:
       <x-forms.radio-group
           name="gender"
           label="الجنس"
           :options="['male' => 'ذكر', 'female' => 'أنثى']"
           checked="male" />

    2. راديو في سطر واحد (inline):
       <x-forms.radio-group
           name="payment_method"
           label="طريقة الدفع"
           :options="$paymentMethods"
           inline
           required />

    3. مع كلاسات مخصصة ونص مساعدة:
       <x-forms.radio-group
           name="status"
           label="حالة المستخدم"
           :options="['active' => 'نشط', 'inactive' => 'معطل']"
           help-text="اختر حالة الحساب"
           item-class="form-check form-check-lg"
           input-class="form-check-input rounded-circle" />

    4. مع Livewire:
       <x-forms.radio-group
           name="role"
           :options="$roles"
           wire:model.live="selected_role"
           inline />

    5. بدون عنوان ومع required:
       <x-forms.radio-group
           name="agree"
           :options="['1' => 'أوافق على الشروط والأحكام']"
           checked="1"
           required
           wrapper-class="mb-0" />
--}}
