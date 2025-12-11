<form method="POST"
    action="{{ isset($category) ? route('dashboard.categories.update', $category) : route('dashboard.categories.store') }}"
    enctype="multipart/form-data" class="row">
    @csrf
    @if (isset($category))
        @method('PUT')
    @endif

    <x-dashboard::form.input
        wrapperClass="col-md-4 col-x-4"
        name="name"
        label="Name"
        value="{{ old('name', $category->name ?? '') }}"
        required
    />

    <x-dashboard::form.select
        wrapperClass="col-md-4 col-x-4"
        name="parent_id"
        label="Parent Category"
        :options="$parents"
        selected="{{ old('parent_id', $category->parent_id ?? '') }}"
        placeholder="Select Parent"
    />

    <x-dashboard::form.checkbox-group
        wrapperClass="col-md-4 col-x-4 mt-4 form-check form-switch"
        inputClass="form-check-input"
        name="is_active"
        labelItemClass="form-check-label ms-2"
        text="{{ __('Active Category') }}"
        :options="['1' => 'Active']"
        checked="{{ old('is_active', $category->is_active ?? 1) }}"
    />

    <x-dashboard::form.input
        wrapperClass="col-md-6 col-x-6"
        name="icon"
        label="Icon"
        value="{{ old('icon', $category->icon ?? '') }}"
        placeholder="fa fa-category"
    />

    <x-dashboard::form.input
        wrapperClass="col-md-6 col-x-6"
        name="sort_order"
        type="number"
        label="Sort Order"
        value="{{ old('sort_order', $category->sort_order ?? 0) }}"
    />

    <x-dashboard::form.file-input
        name="image"
        label="Image"
        accept="image/*"
    />



    <x-dashboard::form.textarea
        wrapperClass="mb-5"
        name="description"
        label="Description"
        value="{{ old('description', $category->description ?? '') }}"
    />

    <x-dashboard::form.action-button
        type="submit"
        divClass="text-end mt-4"
        label="{{ isset($category) ?  __('Update') : __('Create') }}"
        icon="fa fa-check"
        buttonClass="btn btn-primary"
    />
</form>
