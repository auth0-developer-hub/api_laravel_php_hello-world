<?php

return [
    'include' => [
        'X-XSS-Protection' => '0',
        'Strict-Transport-Security' => 'max-age=31536000 ; includeSubDomains',
        'X-Frame-Options' => 'deny',
        'X-Content-Type-Options' => 'nosniff',
        'Content-Security-Policy' => "default-src 'self'; frame-ancestors 'none';",
        'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
        'Content-Type' => 'application/json; charset=utf-8',
    ],
    'exclude' => [
        'X-Powered-By',
        'Server'
    ]
];
