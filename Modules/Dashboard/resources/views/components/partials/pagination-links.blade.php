@props([
    'model'          => ''
    ])

<div class="d-flex justify-content-center mt-4">
    {{ $model->appends(request()->query())->links('pagination::simple-tailwind') }}
</div>
