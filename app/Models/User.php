<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'last_seen',
        'is_online'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * مثال مخصص: جلب المستخدمين الذين هم user أو store-manager أو super-admin
     */
    public function scopeVendorsAndAdmins(Builder $query): Builder
    {
        return $query->hasAnyRole(['user', 'store-manager', 'super-admin']);
    }
    
    /**
     * جلب المستخدمين اللي لديهم دور store-manager فقط
     */
    public function scopeStoreManagers(Builder $query): Builder
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', 'store-manager'));
    }

    /**
     * جلب المستخدمين اللي لديهم دور super-admin فقط
     */
    public function scopeSuperAdmins(Builder $query): Builder
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', 'super-admin'));
    }

    /**
     * جلب المستخدمين اللي لديهم دور user فقط (المستخدمين العاديين)
     */
    public function scopeRegularUsers(Builder $query): Builder
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', 'user'));
    }

    /**
     * جلب المستخدمين اللي لديهم دور user أو ما عندهم أي دور على الإطلاق
     */
    public function scopeRegularUsersOrWithoutRoles(Builder $query): Builder
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', 'user'))
                     ->orWhereDoesntHave('roles');
    }


    /**
     * جلب آخر نشاط للمستخدم من جدول sessions
     */
    public function getLastSeenAttribute(): ?Carbon
    {
        // if (!$this->id) {
            return null;
        // }

        // $session = DB::table('sessions')
        //     ->where('user_id', $this->id)
        //     ->orderBy('last_activity', 'desc')
        //     ->first();

        // return $session ? Carbon::createFromTimestamp($session->last_activity) : null;
    }
    /**
     * هل المستخدم متصل الآن؟ (خلال آخر 5 دقائق)
     */
    public function getIsOnlineAttribute(): bool
    {
        return false;
    }

    /**
     * آخر IP من الجلسة الأخيرة
     */
    // public function getLastSeenIpAttribute(): ?string
    // {
    //     if (!$this->id) {
    //         return null;
    //     }

    //     $session = DB::table('sessions')
    //         ->where('user_id', $this->id)
    //         ->orderBy('last_activity', 'desc')
    //         ->first();

    //     return $session->ip_address ?? null;
    // }
}
