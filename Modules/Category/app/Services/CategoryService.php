<?php

namespace Modules\Category\Services;

use Illuminate\Http\UploadedFile;
use Modules\Category\Models\Category;

class CategoryService
{
    public function getPaginated(array $filters = [])
    {
        $query = Category::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('sort_order')->orderBy('id', 'desc')
                     ->paginate($filters['per_page'] ?? 25)
                     ->withQueryString();
    }

    public function getMainCategories(bool $onlyActive = true)
    {
        $query = Category::main();
        if ($onlyActive) $query->active();
        return $query->orderBy('sort_order')->pluck('name', 'id');
    }

    public function create(array $data): Category
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = upload()->upload($data['image'], 'categories');
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($category->image) {
                upload()->deleteIfExists($category->image);
            }
            $data['image'] = upload()->upload($data['image'], 'categories');
        }

        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        if ($category->image) {
            upload()->deleteIfExists($category->image);
        }

        return $category->delete();
    }
}
/**
 * ===================================================================
 * شرح الكلاس: CategoryService
 * ===================================================================
 * الهدف: إدارة الأقسام (CRUD + فلترة)
 * كيفية الاستخدام:
 *   $service->getPaginated(request()->all());
 * ===================================================================
 */
