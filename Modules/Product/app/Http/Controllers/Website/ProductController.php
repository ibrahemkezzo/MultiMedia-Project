<?php

namespace Modules\Product\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;
use Modules\Website\Services\WebsiteService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show(Request $request,Product $product, WebsiteService $service)
    {
        // جلب منتجات مشابهة (نفس المتجر أو نفس القسم، مع فلترة إضافية لو بدك)
        $relatedProducts = $service->getFilteredProducts(request(), false)
                                   ->where('id', '!=', $product->id)
                                   ->take(8);

        // زيادة عدد المشاهدات (اختياري)
        $product->increment('views_count');

        $product->with(['category','store','store.category']);

        return view('product::website.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
