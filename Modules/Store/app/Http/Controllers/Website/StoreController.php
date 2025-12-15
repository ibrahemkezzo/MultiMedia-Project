<?php

namespace Modules\Store\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Store\Models\Store;
use Modules\Store\Services\StoreService;
use Modules\Website\Services\WebsiteService;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,StoreService $service)
    {
        $stores = $service->getPaginated($request, true);
        return view('store::website.index',compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store::website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show(Request $request, Store $store, WebsiteService $service)
{
    // جلب منتجات المتجر مع فلترة (نفس الفلاتر المستخدمة في الـ index)
    $products = $service->getFilteredProducts($request->merge(['store' => $store->id]));

    return view('store::website.show', compact('store', 'products'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('store::website.edit');
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
