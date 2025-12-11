@props([
    'name'          => 'files',
    'label'         => null,
    'multiple'      => false,
    'accept'        => null,           // image/* أو .pdf,.docx
    'size'          => 'lg',           // sm, md, lg, xl
    'helpText'      => 'اسحب الملفات هنا أو اضغط للرفع',
    'existingFiles' => [],          // array من URLs أو paths للتعديل
    'wrapperClass'  => '',
])

@php
    $id = 'file-input-' . uniqid();

    // أحجام مختلفة
    $height = match($size) {
        'sm' => 'h-150px',
        'md' => 'h-250px',
        'lg' => 'h-350px',
        'xl' => 'h-450px',
        default => 'h-350px'
    };
@endphp

<div class="{{ $wrapperClass }}">
    @if($label)
        <label class="form-label fw-bold">
            {{ __($label) }}
            @if($attributes->has('required') && $attributes->get('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <!-- Drop Zone -->
    <div x-data="fileUploadComponent()"
         x-init="init()"
         @dragover.prevent="dragOver = true"
         @dragleave.prevent="dragOver = false"
         @drop.prevent="drop($event)"
         class="border border-3 border-dashed rounded-4 position-relative overflow-hidden bg-light {{ $height }} d-flex align-items-center justify-content-center cursor-pointer transition-all"
         :class="dragOver ? 'border-primary bg-primary bg-opacity-10 shadow-lg' : 'border-secondary'"
         onclick="document.getElementById('{{ $id }}').click()">

        <!-- Input مخفي -->
        <input type="file"
               id="{{ $id }}"
               name="{{ $multiple ? $name.'[]' : $name }}"
               {{ $multiple ? 'multiple' : '' }}
               @if($accept) accept="{{ $accept }}" @endif
               class="d-none"
               {{ $attributes }}
               x-ref="fileInput"
               @change="filesSelected($event)">

        <!-- محتوى الـ Drop Zone -->
        <div class="text-center z-10">
            <i class="fa fa-cloud-upload-alt text-primary" style="font-size: 70px;"></i>
            <h4 class="mt-3 text-dark fw-bold">{{ $helpText }}</h4>
            @if($accept)
                <p class="text-muted small mb-0">الملفات المسموحة: {{ $accept }}</p>
            @endif
        </div>

        <!-- تأثير الـ Hover -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-0 transition-opacity"
             :class="dragOver ? 'opacity-10' : ''"></div>
    </div>

    <!-- معاينة الملفات -->
    <div x-ref="previewContainer" class="row mt-3 g-3">
        <!-- Existing Files (للتعديل) -->
        @foreach($existingFiles as $file)
            @php
                $url = is_string($file) ? $file : ($file['url'] ?? asset('storage/'.$file));
                $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $url);
            @endphp
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 position-relative">
                <div class="border rounded overflow-hidden shadow-sm">
                    @if($isImage)
                        <img src="{{ $url }}" class="w-100" style="height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 120px;">
                            <i class="fa fa-file fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="position-absolute top-0 end-0 m-2">
                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="{{ $name }}_existing[]" value="{{ is_string($file) ? $file : ($file['path'] ?? $file) }}">
            </div>
        @endforeach
    </div>

    <!-- Validation Error -->
    @error($name)
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
    function fileUploadComponent() {
        return {
            dragOver: false,
            init() {},
            drop(e) {
                this.dragOver = false;
                this.filesSelected(e.dataTransfer);
            },
            filesSelected(input) {
                const files = input.files || input.target.files;
                if (!files.length) return;

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const isImage = file.type.startsWith('image/');
                        const html = `
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 position-relative">
                                <div class="border rounded overflow-hidden shadow-sm">
                                    ${isImage ?
                                        `<img src="${e.target.result}" class="w-100" style="height: 120px; object-fit: cover;">` :
                                        `<div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 120px;">
                                            <i class="fa fa-file fa-3x text-muted"></i>
                                         </div>`
                                    }
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow" onclick="this.parentElement.parentElement.parentElement.remove()">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="{{ $multiple ? $name.'[]' : $name }}" value="${e.target.result}">
                            </div>`;
                        this.$refs.previewContainer.insertAdjacentHTML('beforeend', html);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    }
</script>
@endpush

{{-- =====================================================================
     طريقة الاستخدام (سهلة جدًا)
     ===================================================================== --}}

{{--
    1. رفع صور متعددة:
       <x-forms.file-input name="images" label="صور المنتج" multiple accept="image/*" size="xl" />

    2. رفع ملف واحد (مثل PDF):
       <x-forms.file-input name="contract" label="عقد العمل" accept=".pdf" size="md" />

    3. صورة بروفايل:
       <x-forms.file-input name="avatar" label="صورة الحساب" accept="image/*" size="sm" />

    4. للتعديل (مع ملفات موجودة):
       <x-forms.file-input name="gallery" multiple :existing-files="$product->images->pluck('path')" />
--}}
{{-- =====================================================================
     أمثلة على الاستخدام
     ===================================================================== --}}

{{--
    1. رفع صور المنتج (كبير وجميل):
       <x-forms.file-input
           name="images"
           label="صور المنتج"
           multiple
           accept="image/*"
           size="xl"
           color="primary" />

    2. رفع ملف PDF واحد:
       <x-forms.file-input
           name="document"
           label="ارفع الملف"
           accept=".pdf,.docx"
           size="md"
           color="dark" />

    3. رفع صورة واحدة فقط (مثل الأفاتار):
       <x-forms.file-input
           name="avatar"
           label="صورة الحساب"
           accept="image/*"
           height="h-48"
           color="info" />

    4. للتعديل مع ملفات موجودة:
       <x-forms.file-input
           name="gallery"
           multiple
           :existing-files="$product->images" />
--}}
