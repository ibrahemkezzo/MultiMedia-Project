<?php

return [
    'name' => 'Core',
    'settings_disk' => env('CORE_SETTINGS_DISK', 'public'),
    'settings_cache_ttl' => env('CORE_SETTINGS_CACHE_TTL', 1440), // دقائق
];
