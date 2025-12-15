<?php

namespace Modules\Store\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Store\Models\Store;

class StoreService
{
  public function getPaginated(Request $request, bool $forWebsite = false)
    {
        $query = Store::with(['user', 'category'])
                      ->withCount('products')
                      ->when(!$forWebsite, fn($q) => $q); // لو dashboard، ما نضيف active() إلا لو بدك

        // بحث عام
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhereHas('category', fn ($q) => $q->where('name', 'like', "%$search%"));
        }

        // فلترة بالـ category (المتاجر اللي عندها منتجات من هالقسم)
        if ($request->filled('category')) {
            $categoryId = $request->category;
            $query->where('category_id',$categoryId);
        }

        // فلترة بالـ subcategory
        if ($request->filled('subcategory')) {
            $subcategoryIds = (array) $request->subcategory;
            $query->whereHas('products', fn($q) => $q->whereIn('category_id', $subcategoryIds)->active());
        }

        // فلترة بالمدينة من settings
        if ($request->filled('city')) {
            $city = $request->city;
            $query->whereHas('settings', fn($q) => $q->where('key', 'store_city')->where('value', 'like', "%$city%"));
        }

        // فلترة بالبلد من settings
        if ($request->filled('country')) {
            $country = $request->country;
            $query->whereHas('settings', fn($q) => $q->where('key', 'store_country')->where('value', 'like', "%$country%"));
        }

        // إذا كان للـ Website، نضيف فلتر المتاجر النشطة فقط
        if ($forWebsite) {
            $query->active();
        }

        return $query->orderBy('created_at', 'desc')
                     ->paginate($request->per_page ?? ($forWebsite ? 12 : 25))
                     ->withQueryString();
    }

    public function create(array $data): Store
    {
        try {

            $data['slug'] = Str::slug($data['name']);
            $store = Store::create($data);

            // حفظ الإعدادات الإضافية في settings
            setting_set('store_name', $data['name'], $store->id);
            setting_set('store_address', $data['address'] ?? null, $store->id);
            setting_set('store_city', $data['city'] ?? null, $store->id);
            setting_set('store_country', $data['country'] ?? null, $store->id);
            setting_set('store_phone', $data['phone'] ?? null, $store->id);
            setting_set('store_email', $data['email'] ?? null, $store->id);
            setting_set('store_bio', $data['bio'] ?? null, $store->id);
            if (isset($data['logo_store']) && $data['logo_store'] instanceof UploadedFile) {

                $data['logo_store'] = upload()->upload($data['logo_store'], 'stores');
                setting_set('logo_store', $data['logo_store'] ?? setting_get('default_store_banner'), $store->id);

            }
            if (isset($data['cover_store']) && $data['cover_store'] instanceof UploadedFile) {

                $data['cover_store'] = upload()->upload($data['cover_store'], 'stores');
                setting_set('cover_store', $data['cover_store'] ?? setting_get('default_store_banner'), $store->id);

            }

            $user = $store->user;
            $user->assignRole('store-manager');

            return $store;
        } catch (Exception $e) {

            throw new Exception('Error creating store: '.$e->getMessage());

        }
    }

    public function update(Store $store, array $data): Store
    {
        try {
            $store->update($data);

            // تحديث الإعدادات الإضافية في settings
            setting_set('store_name', $data['name'], $store->id);
            setting_set('store_address', $data['address'] ?? null, $store->id);
            setting_set('store_city', $data['city'] ?? null, $store->id);
            setting_set('store_country', $data['country'] ?? null, $store->id);
            setting_set('store_phone', $data['phone'] ?? null, $store->id);
            setting_set('store_email', $data['email'] ?? null, $store->id);
            setting_set('store_bio', $data['bio'] ?? null, $store->id);

            return $store;
        } catch (Exception $e) {
            throw new Exception('Error updating store: '.$e->getMessage());
        }
    }

    public function delete(Store $store): bool
    {
        try {
            $user = $store->user;

            // حذف المتجر + إعداداته تلقائيًا بـ cascade
            $deleted = $store->delete();

            // إزالة دور store-manager وإعادة دور user
            $user->removeRole('store-manager');
            $user->assignRole('user');

            return $deleted;
        } catch (Exception $e) {
            throw new Exception("Error deleting store: " . $e->getMessage());
        }
    }
}
