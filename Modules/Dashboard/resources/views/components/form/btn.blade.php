{{-- resources/views/components/btn.blade.php --}}
@props([
    'type'      => 'submit',           // submit | button | reset
    'size'      => 'md',               // sm | md | lg | xl
    'color'     => 'primary',          // primary, success, danger, warning, info, dark, light, link
    'outline'   => false,              // true → outline style
    'block'     => false,              // true → full width
    'disabled'  => false,
    'loadingText' => 'جاري المعالجة...', // النص أثناء التحميل
    'icon'      => null,               // fa fa-save
    'iconPosition' => 'left',          // left | right
    'spinner'   => true,               // إظهار spinner تلقائي عند الضغط
])

@php
    // تحديد الكلاسات حسب الحجم
    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        'xl' => 'px-5 py-3 text-lg',
        default => '',
    };

    // تحديد نوع الزر
    $btnType = $outline ? "btn-outline-{$color}" : "btn-{$color}";

    // كلاس العرض الكامل
    $blockClass = $block ? 'w-100' : '';

    // حالة التعطيل
    $isDisabled = $disabled || $attributes->has('disabled');
@endphp

<button
    type="{{ $type }}"
    class="btn {{ $btnType }} {{ $sizeClass }} {{ $blockClass }} d-inline-flex align-items-center justify-content-center gap-2 position-relative overflow-hidden transition-all"
    {{ $attributes->except(['class']) }}
    @if($spinner) x-data="{ loading: false }" @click.prevent="if(!loading){ loading = true; $el.closest('form')?.submit() || $nextTick(() => loading = false) }" @endif
    :disabled="loading || {{ $isDisabled ? 'true' : 'false' }}"
    >

    {{-- النص العادي --}}
    <span x-show="!loading" class="d-flex align-items-center gap-2">
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }}"></i>
        @endif
    </span>

    {{-- حالة التحميل مع Spinner --}}
    {{-- <span x-show="loading" class="d-flex align-items-center gap-2">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span>{{ $loadingText }}</span>
    </span> --}}
</button>

{{-- =====================================================================
     أمثلة على الاستخدام (جاهزة للنسخ واللصق)
     ===================================================================== --}}

{{--
    1. زر حفظ عادي:
       <x-btn>حفظ التغييرات</x-btn>

    2. مع أيقونة + لون أخضر:
       <x-btn color="success" icon="fa fa-check" loading-text="جاري الحفظ...">
           حفظ
       </x-btn>

    3. زر حذف مع تأكيد:
       <x-btn color="danger" icon="fa fa-trash" icon-position="left"
              onclick="if(confirm('متأكد من الحذف؟')) this.closest('form').submit()">
           حذف نهائي
       </x-btn>

    4. زر كبير يملأ العرض:
       <x-btn color="primary" size="lg" block loading-text="جاري الإرسال...">
           إرسال الطلب
       </x-btn>

    5. زر outline + أيقونة يمين:
       <x-btn outline color="info" icon="fa fa-download" icon-position="right">
           تحميل التقرير
       </x-btn>

    6. مع Livewire (بدون spinner يدوي):
       <x-btn wire:click="save" wire:loading.attr="disabled" color="success">
           حفظ
       </x-btn>

    7. زر معطل:
       <x-btn disabled>غير متاح الآن</x-btn>
--}}
