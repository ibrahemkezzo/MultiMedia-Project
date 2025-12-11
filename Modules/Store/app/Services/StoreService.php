<?php

namespace Modules\Store\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Store\Models\Store;

class StoreService
{
    public function getPaginated(Request $request)
    {
        $query = Store::with(['user', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%$search%"))
                ->orWhereHas('category', fn ($q) => $q->where('name', 'like', "%$search%"));
        }

        // فلترة بالمدينة
        if ($request->filled('city')) {
            $city = $request->city;
            $query->whereHas('settings', function ($q) use ($city) {
                $q->where('key', 'store_city')
                    ->where('value', 'like', "%$city%");
            });
        }

        // فلترة بالبلد
        if ($request->filled('country')) {
            $country = $request->country;
            $query->whereHas('settings', function ($q) use ($country) {
                $q->where('key', 'store_country')
                    ->where('value', 'like', "%$country%");
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 25)
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
