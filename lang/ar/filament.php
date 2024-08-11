<?php

return [
    'main_page' => [
        'filter' => [
            'info' => 'فلترة',
            'start' => 'تاريخ البدء',
            'end' => 'تاريخ الإنتهاء',
        ],
        'card' => [
            'category' => 'أصناف',
            'product' => 'منتجات',
            'user' => 'عملاء',
            'order' => 'طلبات',
            'revenu' => 'إجمالي الدخل',
        ],
    ],
    'user_navigation ' => [

        'resource' => 'المستخدمين',

        'list' => 'المستخدمين',

        'view' => 'المستخدم',

        'widget' => [
            'orders' => 'الطلبات',
            'favourites' => 'المنتجات المفضلة',
        ],

        'table' => [
            'name' => 'الإسم',
            'email' => 'الإيميل',
            'phone' => 'رقم الهاتف',
            'gender' => 'النوع',
            'export' => 'تصدير',
        ],

        'form' => [
            'name' => 'الإسم',
            'email' => 'الإيميل',
            'phone' => 'رقم الهاتف',
            'gender' => 'النوع',
            'info' => 'معلومات المستخدم',
        ],

        'relation' => [
            'orders' => [
                'form' => [
                    'info' => 'تفاصيل الاوردر',
                    'total_amount' => 'الكمية الكلية',
                    'payment_id' => 'رقم الدفع',
                    'payment_type' => 'نوع الدفع',
                    'payment_status' => 'حالة الدفع',
                ],
                'table' => [
                    'total_amount' => 'الكمية الكلية',
                    'payment_id' => 'رقم الدفع',
                    'payment_type' => 'نوع الدفع',
                    'payment_status' => 'حالة الدفع',
                ],
            ],
            'favourites' => [
                'form' => [
                    'info' => 'تفاصيل المنتج',
                    'name' => 'الإسم',
                    'description' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'stock' => 'الكمية المخزنة',
                    'alert' => 'أبلغني عند',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
                'table' => [
                    'name' => 'الإسم',
                    'description' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'stock' => 'الكمية المخزنة',
                    'alert' => 'أبلغني عند',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
            ],
        ],
    ],
];
