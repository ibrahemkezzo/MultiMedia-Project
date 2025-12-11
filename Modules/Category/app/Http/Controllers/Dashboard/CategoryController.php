<?php

namespace Modules\Category\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Http\Requests\StoreCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Models\Category;
use Modules\Category\Services\CategoryService;

class CategoryController extends Controller
{
   public function __construct(protected CategoryService $service)
    {
    }

    public function index(Request $request)
    {
        $categories = $this->service->getPaginated($request->all());

        return view('category::dashboard.index', compact('categories'));
    }

    public function create()
    {
        $parents = $this->service->getMainCategories();

        return view('category::dashboard.form', compact('parents'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.categories.index')
                         ->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function edit(Category $category)
    {
        $parents = $this->service->getMainCategories();
        return view('category::dashboard.form', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());

        return redirect()->route('dashboard.categories.index')
                         ->with('success', 'تم تعديل القسم بنجاح');
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);

        return back()->with('success', 'تم حذف القسم بنجاح');
    }
}
