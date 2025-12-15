<?php

namespace Modules\Product\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Models\Product;
use Modules\Product\Services\ProductService;
use Modules\Store\Models\Store;

class ProductController extends Controller
{public function __construct(protected ProductService $service)
    {
    }

    public function index(Request $request)
    {
        $products = $this->service->getPaginated($request);

        return view('product::dashboard.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::child()->active()->pluck('name', 'id');
        $stores = Store::all()->pluck('name', 'id');

        return view('product::dashboard.form', compact('categories','stores'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.products.index')
                         ->with('message', [
                             'type' => 'success',
                             'content' => __('Product created successfully.'),
                         ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::child()->active()->pluck('name', 'id');
        $stores = Store::all()->pluck('name', 'id');

        return view('product::dashboard.form', compact('product', 'categories','stores'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());

        return redirect()->route('dashboard.products.index')
                         ->with('message', [
                             'type' => 'success',
                             'content' => __('Product updated successfully.'),
                         ]);
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);

        return back()->with('message', [
            'type' => 'success',
            'content' => __('Product deleted successfully.'),
        ]);
    }

  public function removeImage(Request $request, Product $product)
{

    $deleted = $this->service->removeMedia($product, $request->media_id);

    return back()->with('message', [
        'type' => $deleted ? 'success' : 'danger',
        'content' => $deleted
            ? __('Image deleted successfully.')
            : __('Image not found.'),
    ]);
}
}
