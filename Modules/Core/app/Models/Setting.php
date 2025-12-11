<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
// use Modules\Core\Database\Factories\SettingFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value', 'type', 'group', 'description',
        'is_translatable', 'store_id'
    ];

    protected $casts = [
        'value' => 'json',
        'is_translatable' => 'boolean',
    ];

    public function scopeGeneral(Builder $query): Builder
    {
        return $query->whereNull('store_id');
    }

    public function scopeForStore(Builder $query, $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }
}
