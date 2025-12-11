<?php

namespace Modules\Store\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Store\Http\Requests\StoreStoreRequest;
use Modules\Store\Http\Requests\UpdateStoreRequest;
use Modules\Store\Models\Store;
use Modules\Store\Services\StoreService;

class StoreController extends Controller
{
    public function __construct(protected StoreService $service)
    {
    }

    public function index(Request $request)
    {
        $stores = $this->service->getPaginated($request);
        $cities = \Modules\Core\Models\Setting::where('key', 'store_city')
            ->whereNotNull('value')
            ->distinct()
            ->pluck('value');

        $countries = \Modules\Core\Models\Setting::where('key', 'store_country')
            ->whereNotNull('value')
            ->distinct()
            ->pluck('value');

        return view('store::dashboard.index', compact('stores','countries','cities'));
    }

    public function create()
    {
        $categories = Category::main()->active()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        return view('store::dashboard.form', compact('categories','users'));
    }

    public function store(StoreStoreRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.stores.index')
                         ->with('message', [
                             'type' => 'success',
                             'content' => __('Store created successfully.'),
                         ]);
    }

    public function edit(Store $store)
    {
        $categories = Category::main()->active()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        return view('store::dashboard.form', compact('store', 'categories','users'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->service->update($store, $request->validated());

        return redirect()->route('dashboard.stores.index')
                         ->with('message', [
                             'type' => 'draft',
                             'content' => __('Store updated successfully.'),
                         ]);
    }

    public function destroy(Store $store)
    {
        $this->service->delete($store);

        return back()->with('message', [
            'type' => 'error',
            'content' => __('Store deleted successfully.'),
        ]);
    }
}

/**
 * ===================================================================
 * شرح الكلاس: StoreController
 * ===================================================================
 * الهدف: إدارة المتاجر في الـ Dashboard (Blade)
 * كيفية الاستخدام:
 *   Route::resource('stores', StoreController::class);
 * ===================================================================
 */
