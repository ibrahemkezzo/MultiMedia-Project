{{--
    الكومبوننت الأسطوري لكل جداولك - النسخة النهائية 2025
    يدعم الصلاحيات + Resource + تخصيص كامل + حذف ذكي
--}}

@props([
    'model'               => '',

    // === الروابط ===
    'resource'            => null,           // مثل: "dashboard.users"
    'showUrl'             => null,
    'editUrl'             => null,
    'deleteUrl'           => null,

    // === التحكم في الأزرار ===
    'canShow'             => true,
    'canEdit'             => true,
    'canDelete'           => true,

    // === الصلاحيات (طريقتان) ===
    'resourcePermissions' => null,           // مثل: "users" → يتحقق من view-users, edit-users, delete-users
    'showPermission'      => null,           // صلاحية مخصصة للعرض
    'editPermission'      => null,           // صلاحية مخصصة للتعديل
    'deletePermission'    => null,           // صلاحية مخصصة للحذف

    // === التصميم ===
    'showIcon'            => 'fa fa-eye',
    'showClass'           => 'me-3 text-info',
    'showTitle'           => null,

    'editIcon'            => 'fa fa-edit',
    'editClass'           => 'me-3 text-warning',
    'editTitle'           => null,

    'deleteIcon'          => 'fa fa-trash',
    'deleteClass'         => 'text-danger',
    'deleteTitle'         => null,

    // === رسالة الحذف ===
    'deleteConfirm'       => [],

    // === أزرار إضافية ===
    'extra'               => '',
])

@php
    $id = $model->id;
    $user = auth()->user();
    // === بناء الروابط تلقائيًا إذا كان resource موجود ===
    if ($resource) {
        $showUrl  = $showUrl  ?? route("{$resource}.show",   $model);
        $editUrl  = $editUrl  ?? route("{$resource}.edit",   $model);
        $deleteUrl = $deleteUrl ?? route("{$resource}.destroy", $model);
    }

    // === تحديد الصلاحيات تلقائيًا إذا مررت resourcePermissions ===
    if ($resourcePermissions) {
        $showPermission   = $showPermission   ?? "view-{$resourcePermissions}";
        $editPermission   = $editPermission   ?? "edit-{$resourcePermissions}";
        $deletePermission = $deletePermission ?? "delete-{$resourcePermissions}";
    }

    // === التحقق النهائي من الصلاحيات ===
    $hasShowPermission   = $showPermission   ? $user?->can($showPermission)   : $canShow;
    $hasEditPermission   = $editPermission   ? $user?->can($editPermission)   : $canEdit;
    $hasDeletePermission = $deletePermission ? $user?->can($deletePermission) : $canDelete;

    // === العناوين ===
    $showTitle  = $showTitle  ?? __('View');
    $editTitle  = $editTitle  ?? __('Edit');
    $deleteTitle = $deleteTitle ?? __('Delete');

    // === إعدادات الحذف ===
    $defaultDeleteConfirm = [
        'title'            => __('Are you sure?'),
        'text'             => __('You will not be able to recover this :item!', ['item' => strtolower(__('item'))]),
        'itemName'         => $model->name ?? $model->title ?? 'record',
        'icon'             => 'warning',
        'confirmButtonText'=> __('Yes, delete it!'),
        'cancelButtonText'=> __('Cancel'),
        'confirmButtonColor'=> '#d33',
        'cancelButtonColor' => '#3085d6',
    ];

    $deleteConfig = array_merge($defaultDeleteConfirm, $deleteConfirm);
    $deleteConfigJson = json_encode($deleteConfig, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

<div class="btn-group" role="group">

    {{-- زر العرض --}}
    @if($hasShowPermission && $showUrl)
        <a href="{{ $showUrl }}"
           class="{{ $showClass }}"
           title="{{ $showTitle }}">
            <i class="{{ $showIcon }}"></i>
        </a>
    @endif

    {{-- زر التعديل --}}
    @if($hasEditPermission && $editUrl)
        <a href="{{ $editUrl }}"
           class="{{ $editClass }}"
           title="{{ $editTitle }}">
            <i class="{{ $editIcon }}"></i>
        </a>
    @endif

    {{-- زر الحذف --}}
    @if($hasDeletePermission && $deleteUrl)
        <a href="javascript:void(0)"
           class="{{ $deleteClass }}"
           onclick="showDeleteConfirm({{ $id }}, {{ $deleteConfigJson }})"
           title="{{ $deleteTitle }}">
            <i class="{{ $deleteIcon }}"></i>
        </a>

        <form id="delete-form-{{ $id }}"
              action="{{ $deleteUrl }}"
              method="POST"
              style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif

    {{-- أزرار إضافية --}}
    {!! $extra !!}

</div>


{{--
<!-- 1. الأسهل: Resource + صلاحيات تلقائية -->
<x-dashboard::form.action-table
    :model="$user"
    resource="dashboard.users"
    resourcePermissions="users"
/>
<!-- يتحقق من: view-users, edit-users, delete-users تلقائيًا -->

<!-- 2. تحكم كامل بالصلاحيات -->
<x-dashboard::form.action-table
    :model="$role"
    resource="dashboard.roles"
    showPermission="view roles"
    editPermission="update roles"
    deletePermission="destroy roles"
/>

<!-- 3. خليط (بعضها تلقائي وبعضها مخصص) -->
<x-dashboard::form.action-table
    :model="$product"
    resource="dashboard.products"
    resourcePermissions="products"     <!-- view-products, edit-products, delete-products -->
    showPermission="view any product"  <!-- تخصيص العرض فقط -->
/>

<!-- 4. بدون صلاحيات (يعتمد على canShow/canEdit) -->
<x-dashboard::form.action-table :model="$post" resource="dashboard.posts" canShow="false" />

<!-- 5. مع رسالة حذف مخصصة -->
<x-dashboard::form.action-table
    :model="$admin"
    resource="dashboard.admins"
    resourcePermissions="admins"
    :deleteConfirm="[
        'title' => 'تحذير خطير!',
        'text' => 'حذف المدير :item سيؤدي لفوضى شاملة!',
        'itemName' => $admin->name,
        'confirmButtonText' => 'أحذف ولا يهمك!'
    ]"
/>
--}}
