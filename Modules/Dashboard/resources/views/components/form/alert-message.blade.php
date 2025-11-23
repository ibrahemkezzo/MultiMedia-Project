{{-- resources/views/components/alert-session.blade.php --}}
@props([
    'duration'     => 4000,   {{-- مدة الرسالة النصية --}}
    'imgDuration'  => 5000,   {{-- مدة الصورة الكبيرة --}}
])

@php
    // === دعم جميع الطرق الممكنة في لارافيل ===
    $msg = session('message'); // الطريقة المعقدة: with('message', [...])

    // لو مفيش message معقد، جرب الطريقة البسيطة
    if (!$msg || !is_array($msg)) {
        if (session()->has('success') || session('status') === 'success') {
            $msg = ['type' => 'success', 'content' => session('success') ?? session('status')];
        } elseif (session()->has('error')) {
            $msg = ['type' => 'error',   'content' => session('error')];
        } elseif (session()->has('draft')) {
            $msg = ['type' => 'draft',   'content' => session('draft')];
        } else {
            $msg = null;
        }
    }

    if (!$msg) return;

    $type    = $msg['type'] ?? 'success';
    $content = $msg['content'] ?? $msg; // لو بعت نص بس
    $img     = $msg['img'] ?? session('img');

    $config = [
        'success' => ['bg' => 'bg-success/95 border-success/50', 'text' => 'text-white',   'icon' => 'fa-check-circle',  'gradient' => 'from-emerald-600 to-teal-700'],
        'error'   => ['bg' => 'bg-danger/95 border-danger/50',   'text' => 'text-white',   'icon' => 'fa-times-circle', 'gradient' => 'from-red-600 to-rose-700'],
        'draft'   => ['bg' => 'bg-warning/95 border-warning/50', 'text' => 'text-dark',    'icon' => 'fa-edit',         'gradient' => 'from-amber-500 to-orange-600'],
    ];

    $style = $config[$type] ?? $config['success'];
@endphp

@if($content || $img)
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, {{ $img ? $imgDuration : $duration }})">

    {{-- 1. رسالة نصية أسفل الشاشة --}}
    @if($content && !$img)
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-4 px-7 py-5 rounded-2xl shadow-2xl backdrop-blur-xl border {{ $style['bg'] }} {{ $style['text'] }} font-bold text-lg"
             style="min-width: 340px; max-width: 92vw; animation: slideUp 0.6s ease, fadeOut 0.8s ease {{ ($duration/1000 - 0.8) }}s forwards;">
            <i class="fa {{ $style['icon'] }} text-3xl"></i>
            <span>{{ $content }}</span>
            <button @click="show = false" class="ms-auto opacity-80 hover:opacity-100">
                <i class="fa fa-times text-xl"></i>
            </button>
        </div>
    @endif

    {{-- 2. رسالة مع صورة كبيرة في المنتصف --}}
    @if($img)
        <!-- Overlay خلفية خفيفة -->
        <div class="fixed inset-0 z-40 bg-gradient-to-br {{ $style['gradient'] }} opacity-40 backdrop-blur-md" x-transition.opacity></div>

        <!-- الصورة مع إطار فخم -->
        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="scale-50 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-700"
             x-transition:leave-end="scale-50 opacity-0">

            <div class="relative p-5 sm:p-8 md:p-10 rounded-3xl bg-white/25 backdrop-blur-2xl border-2 border-white/50 shadow-2xl">
                <img src="{{ $img }}"
                     alt="تم بنجاح"
                     class="w-[280px] sm:w-[340px] md:w-[400px] lg:w-[440px] max-w-[90vw] max-h-[76vh] object-contain rounded-3xl border-8 border-white shadow-2xl">

                @if($content)
                    <div class="absolute -bottom-8 sm:-bottom-10 left-1/2 -translate-x-1/2 bg-gradient-to-r {{ $style['gradient'] }} text-white px-8 py-4 rounded-full text-lg sm:text-xl font-bold shadow-2xl border-2 border-white/40 whitespace-nowrap">
                        {{ $content }}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endif

{{-- تنظيف كل الرسائل من الـ session --}}
@php
    session()->forget(['success', 'error', 'draft', 'status', 'message', 'img']);
@endphp

{{-- الأنيميشنز الجميلة --}}
<style>
    @keyframes slideUp {
        from { transform: translateX(-50%) translateY(120px); opacity: 0; }
        to   { transform: translateX(-50%) translateY(0); opacity: 1; }
    }
    @keyframes fadeOut {
        to { opacity: 0; transform: translateX(-50%) translateY(80px); }
    }
</style>

{{-- =====================================================================
     طريقة الاستخدام (كل الطرق تعمل 100%)
     ===================================================================== --}}

{{--
    1. الطريقة البسيطة (الأكثر شيوعًا):
       ->with('success', 'تم بنجاح!')
       ->with('error', 'حدث خطأ!')
       ->with('draft', 'تم حفظ المسودة')

    2. الطريقة المعقدة (مع صورة أو تحكم كامل):
       ->with('message', [
           'type'    => 'success',   // success | error | draft
           'content' => 'مبروك يا بطل!',
           'img'     => asset('images/congrats.gif'), // اختياري
       ])

    3. مع صورة فقط من الطريقة البسيطة:
       ->with('success', 'مبروك!')
       ->with('img', asset('images/win.gif'))

    فقط أضف في layout الرئيسي:
       <x-alert-session />
--}}
