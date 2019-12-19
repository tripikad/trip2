<?php

/* Simple configuration file for Laravel Sitemap package */
return [
  'use_cache' => false,
  'cache_key' => 'laravel-sitemap.' . config('app.url'),
  'cache_duration' => 3600,
  'escaping' => true,
  'use_limit_size' => false,
  'max_size' => null,
  'use_styles' => false,
  'styles_location' => null,
  'items_per_sitemap' => 1000
];
