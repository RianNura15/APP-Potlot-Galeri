<?php

return [
    'mercant_id' => env('MIDTRANS_MERCHAT_ID'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'is_production' => true,
    'is_sanitized' => true,
    'is_3ds' => true,
];
