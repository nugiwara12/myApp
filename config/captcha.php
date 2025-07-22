<?php

return [
    'sitekey' => env('NOCAPTCHA_SITE_KEY'),
    'secret' => env('NOCAPTCHA_SECRET_KEY'),
    'options' => [
        'timeout' => 30,
    ],
];

