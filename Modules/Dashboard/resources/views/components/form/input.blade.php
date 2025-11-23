@props([
    'name'              => null,                  // اسم الحقل (required)
    'type'              => 'text',                // text, email, password, number, date, etc.
    'value'             => '',                    // القيمة الافتراضية
    'label'             => null,                  // نص الـ label (إذا false أو null ما يظهر)
    'labelClass'        => 'form-label fw-semibold', // كلاسات الـ label
    'wrapperClass'      => 'mb-3',                // كلاسات الـ div اللي يحيط بالحقل
    'inputClass'        => 'form-control',        // كلاسات الـ input الأساسية
    'placeholder'       => null,                  // placeholder (اختياري)
    'iconLeft'          => null,                  // أيقونة يسار (مثل: fa fa-user)
    'iconRight'         => null,                  // أيقونة يمين
    'disabled'          => false,                 // disabled
    'readonly'          => false,                 // readonly
    'required'          => false,                 // إضافة required attribute
    'autocomplete'     => null,                  // autocomplete="off" أو أي قيمة
    'helpText'          => null,                  // نص مساعد تحت الحقل (مثل: "يجب أن يكون 8 أحرف")
    'helpTextClass'     => 'text-muted small',    // كلاسات نص المساعدة
])

@php
    // دمج الكلاسات الإضافية من $attributes
    $inputClasses = $attributes->class([
        $inputClass,
        'is-invalid' => $errors->has($name),
        'pe-5'       => $iconRight,   // مساحة للأيقونة اليمنى
        'ps-5'       => $iconLeft,    // مساحة للأيقونة اليسرى
    ]);

    // جلب القيمة القديمة أو الافتراضية
    $oldValue = old($name, $value);
@endphp

<div class="{{ $wrapperClass }}">
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    {{-- Input Wrapper للأيقونات --}}
    <div class="position-relative">
        {{-- Icon Left --}}
        @if($iconLeft)
            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 z-3">
                <i class="{{ $iconLeft }}"></i>
            </div>
        @endif

        {{-- Input --}}
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $oldValue }}"
            placeholder="{{ $placeholder ?? $label }}"
            {{ $attributes->except(['class']) }}
            {{ $inputClasses }}
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        >

        {{-- Icon Right --}}
        @if($iconRight)
            <div class="position-absolute top-50 end-0 translate-middle-y pe-3 z-3">
                <i class="{{ $iconRight }}"></i>
            </div>
        @endif
    </div>

    {{-- Help Text --}}
    @if($helpText)
        <div class="{{ $helpTextClass }}">{{ $helpText }}</div>
    @endif

    {{-- Validation Error --}}
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- =====================================================================
     شرح طريقة الاستخدام (لا تحتاج تكتب أي كود إضافي أبدًا)
     ===================================================================== --}}

{{--
    أمثلة على الاستخدام:

    1. input عادي بسيط:
       <x-forms.input name="name" label="الاسم الكامل" />

    2. مع placeholder و required:
       <x-forms.input name="email" type="email" label="البريد الإلكتروني" required />

    3. مع أيقونة يسار وكلاسات مخصصة:
       <x-forms.input
           name="username"
           label="اسم المستخدم"
           icon-left="fa fa-user"
           input-class="form-control-lg rounded-pill"
           placeholder="أدخل اسم المستخدم" />

    4. مع أيقونة يمين + نص مساعدة:
       <x-forms.input
           name="password"
           type="password"
           label="كلمة المرور"
           icon-right="fa fa-lock"
           help-text="يجب أن تكون 8 أحرف على الأقل"
           required />

    5. تمرير أي attribute إضافي (مثل data-* أو wire:model):
       <x-forms.input
           name="phone"
           label="رقم الجوال"
           icon-left="fa fa-phone"
           wire:model.live="phone"
           data-mask="0000-000-000" />

    6. بدون label ومع كلاسات مخصصة للـ wrapper:
       <x-forms.input name="search" placeholder="ابحث..." wrapper-class="mb-0" input-class="border-0 shadow-none" />

    كل شيء ممكن من خلال الـ props فقط! لا حاجة لكتابة HTML أو CSS خارجي أبدًا.
--}}
