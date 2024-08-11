<?php

return [
    'main_page' => [
        'filter' => [
            'info' => 'Dasbhoard Filter',
            'start' => 'Start Date',
            'end' => 'End Date',
        ],
        'card' => [
            'category' => 'Categories',
            'product' => 'Products',
            'user' => 'Customers',
            'order' => 'Orders',
            'revenu' => 'Revenu',
        ],
    ],
    'user_navigation' => [

        'resource' => 'Users',

        'list' => 'Users',

        'view' => 'User',

        'widget' => [
            'orders' => 'Orders',
            'favourites' => 'Favourites',
        ],

        'table' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'gender' => 'Gender',
            'export' => 'Export',
        ],

        'form' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'gender' => 'Gender',
            'info' => 'User Information',
        ],

        'relation' => [
            'orders' => [
                'form' => [
                    'info' => 'Order Details',
                    'total_amount' => 'Total Amount',
                    'payment_id' => 'Payment Id',
                    'payment_type' => 'Payment Type',
                    'payment_status' => 'Payment Status',
                ],
                'table' => [
                    'total_amount' => 'Total Amount',
                    'payment_id' => 'Payment Id',
                    'payment_type' => 'Payment Type',
                    'payment_status' => 'Payment Status',
                ],
            ],
            'favourites' => [
                'form' => [
                    'info' => 'Product Details',
                    'name' => 'Name',
                    'description' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Barcode',
                    'stock' => 'Stock',
                    'alert' => 'Alert',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No Units',
                ],
                'table' => [
                    'name' => 'Name',
                    'description' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Barcode',
                    'stock' => 'Stock',
                    'alert' => 'Alert',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No Units',
                ],
            ],
        ],
    ],
];
