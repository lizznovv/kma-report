<?php

return [
    'bitrix' => [
        'webhook_url' => getenv('BITRIX_WEBHOOK') ?: 'https://default-url.com',
        'group_id' => 207,
    ],
    'smtp' => [
        'host' => 'smtp.stream.loc',
        'port' => 25,
    ]
];