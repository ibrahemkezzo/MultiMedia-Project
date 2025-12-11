@props([
    'name'              => null,
    'value'             => '',
    'label'             => null,
    'labelClass'        => '',
    'wrapperClass'      => '',
    'textareaClass'     => 'form-control',
    'placeholder'       => null,
    'required'          => false,
    'helpText'          => null,
    'helpTextClass'     => '',
    'validationBag'     => null, // مثل input component
])

@php
    // جلب القيمة القديمة
    $oldValue = old($name, $value);

    // التحقق من الأخطاء
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
    $textareaClasses = $attributes->class([
        $textareaClass,
        'is-invalid' => $hasError,
    ]);
@endphp

<div class="{{ $wrapperClass }}">
    {{-- LABEL --}}
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ __($label) }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    {{-- TEXTAREA --}}
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="4"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $textareaClasses }}
        {{ $attributes->except(['class']) }}
    >{{ $oldValue }}</textarea>

    {{-- HELP TEXT --}}
    @if($helpText)
        <div class="{{ $helpTextClass }}">{{ $helpText }}</div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($hasError && $errorMessage)
        <div class="invalid-feedback d-block">
            {{ $errorMessage }}
        </div>
    @endif
</div>
