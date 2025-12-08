{{-- resources/views/components/dashboard/form/input.blade.php --}}

@props([
    'name'              => null,
    'type'              => 'text',
    'value'             => '',
    'label'             => null,
    'labelClass'        => '',
    'wrapperClass'      => '',
    'inputClass'        => 'form-control',
    'devClass'          => '',
    'placeholder'       => null,
    'iconLeft'          => null,
    'iconRight'         => null,
    'disabled'          => false,
    'readonly'          => false,
    'required'          => false,
    'autocomplete'      => null,
    'helpText'          => null,
    'helpTextClass'     => '',
    'validationBag'     => null, // اختياري: تحديد bag معين (مثل: 'updatePassword')
])

@php
    // جلب القيمة القديمة (من أي bag)
    $oldValue = old($name, $value);

    // التحقق من وجود خطأ في الـ default bag أو في bag مخصص
    $hasError = $errors->has($name);
    $errorMessage = $errors->first($name);

    if ($validationBag) {
        $bag = $errors->getBag($validationBag);
        if ($bag->has($name)) {
            $hasError = true;
            $errorMessage = $bag->first($name);
        }
    } elseif ($errors->any()) {
        foreach ($errors->getBags() as $bag) {
            if ($bag->has($name)) {
                $hasError = true;
                $errorMessage = $bag->first($name);
                break;
            }
        }
    }

    // دمج الكلاسات
    $inputClasses = $attributes->class([
        $inputClass,
        'is-invalid' => $hasError,
        'pe-5'       => $iconRight,
        'ps-5'       => $iconLeft,
    ]);
@endphp

<div class="{{ $wrapperClass }}">
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ __($label) }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    <div class="{{ $devClass }}">
        @if($iconLeft)
            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 z-3 pointer-events-none">
                <i class="{{ $iconLeft }}"></i>
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $oldValue }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->except(['class']) }}
            {{ $inputClasses }}
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        >

        @if($iconRight)
            <div class="position-absolute top-50 end-0 translate-middle-y pe-3 z-3 pointer-events-none">
                <i class="{{ $iconRight }}"></i>
            </div>
        @endif
    </div>

    @if($helpText)
        <div class="{{ $helpTextClass }}">{{ $helpText }}</div>
    @endif

    @if($hasError && $errorMessage)
        <div class="invalid-feedback d-block">
            {{ $errorMessage }}
        </div>
    @endif
</div>
{{--
    أمثلة على الاستخدام:

    1. input عادي بسيط:
       <x-dashboard::form.input name="name" label="الاسم الكامل" />

    2. مع placeholder و required:
       <x-dashboard::form.input name="email" type="email" label="البريد الإلكتروني" required />

    3. مع أيقونة يسار وكلاسات مخصصة:
       <x-dashboard::form.input
           name="username"
           label="اسم المستخدم"
           icon-left="fa fa-user"
           input-class="form-control-lg rounded-pill"
           placeholder="أدخل اسم المستخدم" />

    4. مع أيقونة يمين + نص مساعدة:
       <x-dashboard::form.input
           name="password"
           type="password"
           label="كلمة المرور"
           icon-right="fa fa-lock"
           help-text="يجب أن تكون 8 أحرف على الأقل"
           required />

    5. تمرير أي attribute إضافي (مثل data-* أو wire:model):
       <x-dashboard::form.input
           name="phone"
           label="رقم الجوال"
           icon-left="fa fa-phone"
           wire:model.live="phone"
           data-mask="0000-000-000" />

    6. بدون label ومع كلاسات مخصصة للـ wrapper:
       <x-dashboard::form.input name="search" placeholder="ابحث..." wrapper-class="mb-0" input-class="border-0 shadow-none" />

    كل شيء ممكن من خلال الـ props فقط! لا حاجة لكتابة HTML أو CSS خارجي أبدًا.
--}}
{{--
<!-- 1. عادي (بدون bag) -->
<x-dashboard::form.input name="title" label="العنوان" />

<!-- 2. مع Fortify Profile -->
<x-dashboard::form.input
    name="name"
    label="الاسم"
    validation-bag="updateProfileInformation"
/>

<!-- 3. مع Fortify Password -->
<x-dashboard::form.input
    name="password"
    type="password"
    label="كلمة المرور"
    validation-bag="updatePassword"
/>

<!-- 4. بدون تحديد bag (الأفضل دائمًا!) -->
<x-dashboard::form.input name="email" label="البريد" />
<!-- يعمل مع أي bag تلقائيًا -->
--}}
