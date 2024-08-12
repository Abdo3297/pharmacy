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
    'user_navigation' => [

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
    'category_navigation' => [

        'resource' => 'الفئات',

        'list' => 'الفئات',

        'create' => 'إضافة فئة',
        
        'edit' => 'تعديل الفئة',

        'view' => 'الفئة',

        'widget' => [
            'total_product_category' => 'عدد المنتجات فى الفئة'
        ],

        'table' => [
            'name' => 'الإسم',
            'image' => 'الصورة',
            'export' => 'تصدير',
        ],

        'form' => [
            'name' => 'الاسم',
            'image' => 'الصورة',
            'info' => 'تفاصيل الفئة',
        ],
    ],
    'product_navigation' => [

        'resource' => 'المنتجات',

        'list' => 'المنتجات',
        'create' => 'إضافة منتج',
        'edit' => 'تعديل منتج',
        'view' => 'المنتج',

        'widget' => [
            'orders' => 'Orders',
            'favourites' => 'Favourites',
        ],

        'table' => [
            'name' => 'الاسم',
            'desc' => 'الوصف',
            'image' => 'الصورة',
            'barcode' => 'البار كود',
            'stock' => 'المخزون',
            'alert' => 'حد التنبيه',
            'unit_price' => 'سعر الوحدة',
            'no_units' => 'عدد الوحدات',
            'export' => 'تصدير',
        ],

        'form' => [
            'name' => 'الاسم',
            'desc' => 'الوصف',
            'image' => 'صور المنتج',
            'barcode' => 'البار كود',
            'stock' => 'المخزون',
            'alert' => 'حد التنبيه',
            'unit_price' => 'سعر الوحدة',
            'no_units' => 'عدد الوحدات',
            'info' => 'تفاصيل المنتج',
        ],

        'relation' => [
            'categories' => [
                'form' => [
                    'info' => 'تفاصيل الفئة',
                    'name' => 'الفئات',
                    'image' => 'الصورة'
                ],
                'table' => [
                    'name' => 'الاسم',
                    'image' => 'الصورة'
                ],
            ],
            'sideffects' => [
                'form' => [
                    'info' => 'تفاصيل الأعراض الجانبية',
                    'name' => 'الأعراض الجانبية',
                ],
                'table' => [
                    'name' => 'الاسم',
                ],
            ],
            'indications' => [
                'form' => [
                    'info' => 'تفاصيل دواعى الإستعمال',
                    'name' => 'دواعى الإستعمال',
                ],
                'table' => [
                    'name' => 'الاسم',
                ],
            ],
            'offers' => [
                'form' => [
                    'info' => 'تفاصيل العروض',
                    'name' => 'العروض',
                    'discount_type' => 'نوع الخصم',
                    'discount_value' => 'قيمة الخصم',
                    'start_date' => 'تاريخ البدء',
                    'end_date' => 'تاريخ الإنتهاء'
                ],
                'table' => [
                    'name' => 'الاسم',
                    'discount_type' => 'نوع الخصم',
                    'discount_value' => 'قيمة الخصم',
                    'start_date' => 'تاريخ البدء',
                    'end_date' => 'تاريخ الإنتهاء'
                ],
            ],
        ],
    ],
];
