@props([
    'name'              => null,                  // اسم الحقل (required)
    'label'             => null,                  // نص الـ label
    'options'           => [],                    // array أو Collection من الخيارات: ['value' => 'text'] أو [1 => 'نص', 'group' => [...]]
    'selected'          => '',                    // القيمة المختارة افتراضيًا (أو array للـ multiple)
    'placeholder'       => 'اختر من القائمة',     // نص الـ placeholder (يظهر كخيار أول معطل)
    'multiple'          => false,                 // تفعيل الـ multiple
    'size'              => null,                  // sm, lg (يضيف form-select-sm أو lg)
    'labelClass'        => 'form-label fw-semibold',
    'wrapperClass'      => 'mb-3',
    'selectClass'       => 'form-select',         // كلاسات الـ select الأساسية
    'iconLeft'          => null,                  // أيقونة يسار
    'iconRight'         => null,                  // أيقونة يمين (مثل سهم أو بحث)
    'required'          => false,
    'disabled'          => false,
    'helpText'          => null,
    'helpTextClass'     => 'text-muted small',
    'searchable'        => false,                 // إضافة data-allow-search للمكتبات مثل Choices.js أو TomSelect
])

@php
    // دمج الكلاسات
    $selectClasses = $attributes->class([
        $selectClass,
        'is-invalid' => $errors->has($name),
        'form-select-sm' => $size === 'sm',
        'form-select-lg' => $size === 'lg',
        'pe-5' => $iconRight,
        'ps-5' => $iconLeft,
    ]);

    // تحديد القيمة القديمة أو المختارة
    $oldValue = old($name, $selected);
    if ($multiple && !is_array($oldValue)) {
        $oldValue = $oldValue ? [$oldValue] : [];
    }
@endphp

<div class="{{ $wrapperClass }}">
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    {{-- Select Wrapper للأيقونات --}}
    <div class="position-relative">
        @if($iconLeft)
            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 z-3">
                <i class="{{ $iconLeft }}"></i>
            </div>
        @endif

        <select
            name="{{ $multiple ? $name.'[]' : $name }}"
            id="{{ $name }}"
            {{ $attributes->except(['class']) }}
            class="{{ $selectClasses }}"
            @if($multiple) multiple @endif
            @if($disabled) disabled @endif
            @if($required) required @endif
            @if($searchable) data-allow-search="true" @endif
        >
            {{-- Placeholder Option --}}
            @if($placeholder)
                <option value="" disabled {{ !$oldValue ? 'selected' : '' }}>
                    {{ $placeholder }}
                </option>
            @endif

            {{-- الخيارات العادية أو المجمعة --}}
            @foreach($options as $value => $text)
                @if(is_array($text))
                    <!-- Optgroup -->
                    <optgroup label="{{ $value }}">
                        @foreach($text as $optValue => $optText)
                            <option value="{{ $optValue }}"
                                {{ $multiple
                                    ? (in_array($optValue, (array)$oldValue) ? 'selected' : '')
                                    : ($optValue == $oldValue ? 'selected' : '')
                                }}>
                                {{ $optText }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <!-- Option عادي -->
                    <option value="{{ $value }}"
                        {{ $multiple
                            ? (in_array($value, (array)$oldValue) ? 'selected' : '')
                            : ($value == $oldValue ? 'selected' : '')
                        }}>
                        {{ $text }}
                    </option>
                @endif
            @endforeach
        </select>

        @if($iconRight)
            <div class="position-absolute top-50 end-0 translate-middle-y pe-3 z-3 pointer-events-none">
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
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

{{-- =====================================================================
     شرح طريقة الاستخدام (كل شيء من الـ props فقط!)
     ===================================================================== --}}

{{--
    أمثلة سريعة:

    1. Select عادي:
       <x-forms.select name="country" label="الدولة" :options="$countries" />

    2. مع placeholder و required:
       <x-forms.select name="city" label="المدينة" :options="$cities" placeholder="اختر المدينة" required />

    3. مع أيقونة وكلاسات مخصصة:
       <x-forms.select
           name="role"
           label="الصلاحية"
           :options="$roles"
           icon-right="fa fa-chevron-down"
           select-class="form-select-lg rounded-pill"
           size="lg" />

    4. Multiple select:
       <x-forms.select
           name="permissions"
           label="الصلاحيات"
           :options="$permissions"
           :selected="$user->permissions->pluck('id')->toArray()"
           multiple
           size="sm" />

    5. مع Optgroups:
       :options="[
           'asia' => ['sa' => 'السعودية', 'ae' => 'الإمارات'],
           'europe' => ['fr' => 'فرنسا', 'de' => 'ألمانيا']
       ]"

    6. قابل للبحث (مع Choices.js أو TomSelect):
       <x-forms.select name="user" label="المستخدم" :options="$users" searchable />

    7. أي attribute إضافي:
       <x-forms.select name="category" :options="$categories" wire:model.live="category_id" />

    كل شيء مرن ولا تحتاج تعدل الكمبوننت أبدًا!
--}}
