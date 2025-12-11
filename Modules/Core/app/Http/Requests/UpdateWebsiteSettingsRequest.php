<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'site_name' => ['sometimes', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:1000'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'site_description' => ['nullable', 'string', 'max:500'],

            'social_facebook' => [
                'nullable',
                'string',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+$/i',
            ],

            'social_instagram' => [
                'nullable',
                'string',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.+$/i',
            ],

            'social_twitter' => [
                'nullable',
                'string',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(twitter|x)\.com\/.+$/i',
            ],

            'social_tiktok' => [
                'nullable',
                'string',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/.+$/i',
            ],

            'social_youtube' => [
                'nullable',
                'string',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i',
            ],

            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:512'],
            'default_store_banner' => ['nullable', 'image', 'max:4096'],

            'default_currency' => ['sometimes', 'string', 'max:10'],
            'timezone' => ['sometimes', 'string', 'max:100'],
            'locale' => ['sometimes', 'string', 'max:10'],
            'items_per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'stripe_key' => ['nullable', 'string', 'max:255'],
            'stripe_secret' => ['nullable', 'string', 'max:255'],
            'smtp_host' => ['nullable', 'string', 'max:255'],
            'smtp_port' => ['nullable', 'integer'],
            'smtp_username' => ['nullable', 'string', 'max:255'],
            'smtp_encryption' => ['nullable', 'in:ssl,tls,null'],
            'smtp_from_address' => ['nullable', 'email'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],
            'footer_text' => ['nullable', 'string', 'max:2000'],
        ];

    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('super-admin');
    }
}
