<?php

return [
    'domain' => env('AUTH0_DOMAIN'),
    'audience' => [
        env('AUTH0_AUDIENCE')
    ]
];
