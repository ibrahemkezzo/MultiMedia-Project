{{--
    أقوى كومبوننت زر في لارافل 2025
    ديناميكي 100% — يدعم كل شيء ممكن تتخيله
--}}

@props([
    // نوع الزر
    'type' => 'button', // button | submit | reset

    'divClass' => null,
    // النص داخل الزر
    'label' => '',

    // الأيقونة (FontAwesome)
    'icon' => null,
    'iconPosition' => 'left', // left | right

    // الكلاسات (Bootstrap أو Tailwind أو أي شيء)
    'buttonClass' => 'btn btn-primary',

    // عنوان الـ tooltip
    'title' => null,

    // هل الزر معطل؟
    // 'disabled' => false,

    // إذا كان زر "Next" أو "Previous" في التبويبات
    'tabTarget' => null, // مثل: #roles-tab

    // إذا كان زر يرسل فورم
    // 'form' => null,

    // أي أتريبيوت إضافي (data-*, onclick, wire:click...)
    'attributes' => [],
])

@php
    // تحديد الكلاس النهائي
    // $buttonClass = $class . ($disabled ? ' disabled' : '');

    // بناء الأيقونة
    $iconHtml = $icon ? "<i class=\"{$icon}\"></i>" : '';

    // ترتيب النص والأيقونة
    $content = $iconPosition === 'right'
        ? "{$label} {$iconHtml}"
        : "{$iconHtml} {$label}";
@endphp
<div class="{{ $divClass }}">
    <button
        type="{{ $type }}"
        class="{{ $buttonClass }}"
        title="{{ $title }}"
        {{-- @if($disabled) disabled @endif --}}
        @if($tabTarget) onclick="document.querySelector('a[href=\'{{ $tabTarget }}\']').click()" @endif
        {{-- @if($form) form="{{ $form }}" @endif     --}}
        {{ $attributes }}
    >
        {!! $content !!}
    </button>
</div>
{{--
<!-- 1. زر "التالي" (مثل اللي عندك بالضبط) -->
<x-dashboard::form.action-button
    label="{{ __('Next') }}"
    icon="arrow-right"
    class="btn btn-primary"
    tabTarget="#roles-tab"
/>

<!-- 2. زر "السابق" -->
<x-dashboard::form.action-button
    label="{{ __('Previous') }}"
    icon="arrow-left"
    iconPosition="right"
    class="btn btn-secondary prev-tab"
/>

<!-- 3. زر حفظ (Submit) -->
<x-dashboard::form.action-button
    type="submit"
    label="{{ __('Save Changes') }}"
    icon="check"
    class="btn btn-success"
/>

<!-- 4. زر حذف مع تأكيد SweetAlert -->
<x-dashboard::form.action-button
    type="button"
    label="{{ __('Delete') }}"
    icon="trash"
    class="btn btn-danger"
    onclick="confirmDelete(123, 'محمد')"
/>

<!-- 5. زر طباعة -->
<x-dashboard::form.action-button
    label="Print"
    icon="print"
    class="btn btn-outline-dark"
    onclick="window.print()"
/>

<!-- 6. زر معطل -->
<x-dashboard::form.action-button
    label="غير متاح"
    icon="lock"
    class="btn btn-secondary"
    disabled
/>

<!-- 7. زر مع Livewire -->
<x-dashboard::form.action-button
    label="تحديث"
    icon="sync"
    class="btn btn-info"
    wire:click="refreshData"
/>

<!-- 8. زر مخصص 100% -->
<x-dashboard::form.action-button
    type="button"
    label="إعادة تعيين كلمة المرور"
    icon="key"
    iconPosition="right"
    class="btn btn-warning text-white"
    title="سيرسل رابط إعادة تعيين"
    onclick="resetPassword(55)"
/>
--}}
