<?php

return [
    'otp' => [
        'TYPE' => 'numeric',
        'LENGTH' => 4,
        'VALID' => 3,
    ],
    'currency-prefix' => '£', // $ or £
    'seeder' => [
        'chunkSize' => 2,
        'totalRecords' => 10,
    ],
];
