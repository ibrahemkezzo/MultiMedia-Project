{{-- resources/views/components/table/action-delete.blade.php --}}

@props([
    'model'          => '',
    'route'          => '',
    'confirm'        => [], // هنا السحر: كل شيء قابل للتخصيص
    'icon'           => 'fa fa-trash',
    'class'          => 'text-danger',
    'title'          => null,
])

@php
    $id = $model->id;

    // القيم الافتراضية (جميلة ومتوافقة مع قالبك)
    $defaultConfirm = [
        'title'            => __('Are you sure?'),
        'text'             => __('You will not be able to recover this :item!', ['item' => strtolower(__('item'))]),
        'itemName'         => $model->name ?? $model->title ?? 'record',
        'icon'             => 'warning',
        'confirmButtonText'=> __('Yes, delete it!'),
        'cancelButtonText'=> __('Cancel'),
        'confirmButtonColor'=> '#d33',
        'cancelButtonColor' => '#3085d6',
    ];

    // دمج الإعدادات المرسلة مع الافتراضية
    $config = array_merge($defaultConfirm, $confirm);

    // تحويل إلى JSON آمن للـ JavaScript
    $configJson = json_encode($config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

<a href="javascript:void(0)"
   class="{{ $class }}"
   onclick="showDeleteConfirm({{ $id }}, {{ $configJson }})"
   title="{{ $title ?? __('Delete') }}">
   @if ($icon !== '')
       <i class="{{ $icon }}"></i>
   @endif
</a>

<form id="delete-form-{{ $id }}"
      action="{{ route($route , $model) }}"
      method="POST"
      style="display: none;">
    @csrf
    @method('DELETE')
</form>
