<?php

namespace Modules\Website\Services;

use Illuminate\Http\Request;
use Modules\Product\Models\Product;

class WebsiteService
{
   /**
     * جلب المنتجات مع فلترة متقدمة (للـ Home أو Offers)
     */
    public function getFilteredProducts(Request $request, bool $offersOnly = false): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Product::active()
                        ->with(['store', 'category'])
                        ->when($offersOnly, fn($q) => $q->whereNotNull('compare_price')->whereColumn('compare_price', '>', 'price'));

        // فلترة بالـ category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        // فلترة بالـ subcategory (إذا متعدد)
        if ($request->filled('subcategory')) {
            $query->whereIn('category_id', (array) $request->subcategory);
        }

        // فلترة بالسعر
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // فلترة بالـ rating
        // if ($request->filled('min_rating')) {
        //     $query->where('rating', '>=', $request->min_rating);
        // }

        // فلترة بالمخزون (in stock only)
        if ($request->filled('in_stock')) {
            $query->inStock();
        }

        // بحث عام
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->orderBy('sort_order')
                     ->orderBy('created_at', 'desc')
                     ->paginate($request->per_page ?? 20)
                     ->withQueryString();
    }
}
