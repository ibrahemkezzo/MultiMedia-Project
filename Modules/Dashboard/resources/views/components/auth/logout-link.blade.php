{{--
    كومبوننت تسجيل خروج احترافي 100%
    يدعم:
    - أيقونة FontAwesome
    - أيقونة SVG مخصصة
    - أي محتوى HTML داخل الرابط (slot)
    - أي attribute إضافي (class, data-*, wire:click...)
    - تأكيد SweetAlert2 قابل للتخصيص
--}}

@props([
    'confirm'         => true,
    'confirmTitle'    => 'هل أنت متأكد؟',
    'confirmText'     => 'ستتم إعادة توجيهك إلى صفحة تسجيل الدخول',
    'confirmIcon'     => 'warning',
    'confirmButton'   => 'نعم، خروج',
    'cancelButton'    => 'إلغاء',
])

<a href="javascript:void(0)"
   onclick="logoutUser(event)"
   {{ $attributes->merge(['class' => 'text-danger ' . ($attributes['class'] ?? '')]) }}
   style="cursor: pointer;">
    {{ $slot->isEmpty() ? 'تسجيل الخروج' : $slot }}
</a>

<!-- الفورم المخفي -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function logoutUser(event) {
        event.preventDefault();
        event.stopPropagation();

        @if($confirm)
            Swal.fire({
                title: "{{ $confirmTitle }}",
                text: "{{ $confirmText }}",
                icon: "{{ $confirmIcon }}",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: `<i class="fa fa-sign-out-alt"></i> {{ $confirmButton }}`,
                cancelButtonText: `<i class="fa fa-times"></i> {{ $cancelButton }}`,
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        @else
            document.getElementById('logout-form').submit();
        @endif
    }
</script>
@endpush


{{--
<x-auth.logout-link class="d-flex align-items-center gap-2 text-danger">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round" class="feather feather-log-out">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
    </svg>
    <span>تسجيل الخروج</span>
</x-auth.logout-link>


<x-auth.logout-link class="text-danger" title="تسجيل الخروج">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
    </svg>
</x-auth.logout-link>

<x-auth.logout-link class="text-danger" title="تسجيل الخروج">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
    </svg>
</x-auth.logout-link>


<li>
    <x-auth.logout-link class="dropdown-item d-flex align-items-center gap-2 text-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        تسجيل الخروج
    </x-auth.logout-link>
</li>

<x-auth.logout-link class="text-danger">
    <i class="fa fa-sign-out-alt me-2"></i> خروج
</x-auth.logout-link>

<x-auth.logout-link
    class="text-danger"
    confirmTitle="تأكيد الخروج"
    confirmText="سيتم إنهاء جميع الجلسات الحالية"
    confirmButton="خروج الآن">
    <svg ...> ... </svg>
    خروج
</x-auth.logout-link>
--}}
