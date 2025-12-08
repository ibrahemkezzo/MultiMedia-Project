@props([
    'href'       => null,     // رابط كامل (يُستخدم إذا وُجد)
    'route'      => null,     // اسم الراوت مثل: dashboard.users.show
    'model'      => null,     // الكائن (User, Role, Post...)
    'params'     => [],       // بارامترات إضافية للراوت
    'type'       => null,     // 'show' | 'edit' → يُفعّل التصميم الافتراضي
    'icon'       => null,     // اسم الأيقونة من FontAwesome (بدون fa-)
    'title'      => null,     // نص الـ title
    'class'      => '',       // كلاسات إضافية على الـ <a>
    'label'      => null,
])

@php
    // تحديد الرابط النهائي
    if ($href) {
        $url = $href;
    } elseif ($route && $model) {
        $url = route($route, array_merge([$model], $params));
    } elseif ($route) {
        $url = route($route, $params);
    } else {
        $url = '#';
    }

    // التصميم الافتراضي حسب type (تمامًا مثل طلبك الأصلي)
    $defaultClass = '';
    $defaultIcon  = '';
    $defaultTitle = '';

    if ($type === 'edit') {
        $defaultClass = 'me-3 text-warning';
        $defaultIcon  = 'fa fa-edit';
        $defaultTitle = __('Edit');
    } elseif ($type === 'show') {
        $defaultClass = 'me-3 text-info';
        $defaultIcon  = 'fa fa-eye';
        $defaultTitle = __('View');
    }

    $finalClass = $class ?: $defaultClass;
    $finalIcon  = $icon ?: $defaultIcon;
    $finalTitle = $title ?: $defaultTitle;
@endphp

<a href="{{ $url }}"
   class="{{ $finalClass }} {{ $attributes->get('class') }}"
   title="{{ $finalTitle }}"
   {{ $attributes->except(['class']) }}>
   @if ($defaultIcon !== '')
        <i class="{{ $finalIcon }}"></i>
   @endif
   @if($label)
        {{ __($label) }}
   @endif
</a>
{{--
    كومبوننت رابط عمليات ديناميكي 100%
    يعمل مع أي مودل، أي راوت، أي أيقونة، أي عنوان، أي كلاس

    أمثلة استخدام:

    1. افتراضي (type=edit أو show):
       → تصميمك الأصلي بالضبط)
       <x-dashboard::form.action-link type="edit" :model="$user" />
       <x-dashboard::form.action-link type="show" :model="$user" />

    2. مخصص تمامًا:
       <x-dashboard::form.action-link
           href="{{ route('dashboard.users.profile', $user) }}"
           icon="user-circle"
           title="الملف الشخصي"
           class="text-success"
       />

    3. مع راوت مخصص:
       <x-dashboard::form.action-link :href="route('dashboard.posts.show', $post)" icon="file-text" title="عرض المقال" />
--}}
