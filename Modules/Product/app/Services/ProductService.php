<?php

namespace Modules\Product\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;

class ProductService
{
public function getPaginated(Request $request, ?int $storeId = null)
    {
        $query = Product::with(['store', 'category'])
                        ->when($storeId, fn($q) => $q->where('store_id', $storeId));

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->orderBy('sort_order')
                     ->orderBy('created_at', 'desc')
                     ->paginate($request->per_page ?? 25)
                     ->withQueryString();
    }

    public function create(array $data): Product
    {
        try {
            $data['slug'] = Str::slug($data['name']);

            $product = Product::create($data);

            // رفع الصور
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    if ($image instanceof UploadedFile) {
                        $product->addMedia($image, 'gallery');
                    }
                }
            }

            return $product->load('media');
        } catch (Exception $e) {
            throw new Exception("Error creating product: " . $e->getMessage());
        }
    }

    public function update(Product $product, array $data): Product
    {
        try {
            $data['slug'] = Str::slug($data['name']);

            $product->update($data);

            // تحديث الصور
            if (isset($data['images']) && is_array($data['images'])) {
                $product->clearMediaCollection('gallery');
                foreach ($data['images'] as $image) {
                    if ($image instanceof UploadedFile) {
                        $product->addMedia($image, 'gallery');
                    }
                }
            }

            return $product->load('media');
        } catch (Exception $e) {
            throw new Exception("Error updating product: " . $e->getMessage());
        }
    }

    public function delete(Product $product): bool
    {
        try {
            $product->clearMediaCollection('gallery');
            return $product->delete();
        } catch (Exception $e) {
            throw new Exception("Error deleting product: " . $e->getMessage());
        }
    }

      public function removeMedia(Product $product, int $mediaId): bool
    {
        return $product->deleteMedia($mediaId);
    }
}
