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
            'country' => 'الدولة',
            'gender' => 'النوع',
            'export' => 'تصدير',
        ],
        'form' => [
            'name' => 'الإسم',
            'email' => 'الإيميل',
            'phone' => 'رقم الهاتف',
            'country' => 'الدولة',
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
            'total_product_category' => 'عدد المنتجات فى الفئة',
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
        'relation' => [
            'products' => [
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
                    'image' => 'الصورة',
                ],
                'table' => [
                    'name' => 'الاسم',
                    'image' => 'الصورة',
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
                    'end_date' => 'تاريخ الإنتهاء',
                ],
                'table' => [
                    'name' => 'الاسم',
                    'discount_type' => 'نوع الخصم',
                    'discount_value' => 'قيمة الخصم',
                    'start_date' => 'تاريخ البدء',
                    'end_date' => 'تاريخ الإنتهاء',
                ],
            ],
        ],
    ],
    'indication_navigation' => [

        'resource' => 'دواعى الإستعمال',

        'list' => 'دواعى الإستعمال',
        'create' => 'إضافة دواعى الإستعمال',
        'edit' => 'تعديل دواعى الإستعمال',
        'view' => 'دواعى الإستعمال',

        'table' => [
            'name' => 'الإسم',
            'export' => 'تصدير',
        ],

        'form' => [
            'name' => 'الإسم',
            'info' => 'تفاصيل دواعى الاستعمال',
        ],

        'relation' => [
            'products' => [
                'form' => [
                    'info' => 'تفاصيل المنتج',
                    'name' => 'الإسم',
                    'desc' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'alert' => 'حد التنبيه',
                    'stock' => 'المخزون',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
                'table' => [
                    'name' => 'الإسم',
                    'desc' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'alert' => 'حد التنبيه',
                    'stock' => 'المخزون',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
            ],
        ],
    ],
    'side_navigation' => [

        'resource' => 'الأعراض الجانبية',

        'list' => 'الأعراض الجانبية',
        'create' => 'إضافة الأعراض الجانبية',
        'edit' => 'تعديل الأعراض الجانبية',
        'view' => 'الأعراض الجانبية',

        'table' => [
            'name' => 'الإسم',
            'export' => 'تصدير',
        ],

        'form' => [
            'name' => 'الإسم',
            'info' => 'تفاصيل الأعراض الجانبية',
        ],

        'relation' => [
            'products' => [
                'form' => [
                    'info' => 'تفاصيل المنتج',
                    'name' => 'الإسم',
                    'desc' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'alert' => 'حد التنبيه',
                    'stock' => 'المخزون',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
                'table' => [
                    'name' => 'الإسم',
                    'desc' => 'الوصف',
                    'image' => 'الصورة',
                    'barcode' => 'الباركود',
                    'alert' => 'حد التنبيه',
                    'stock' => 'المخزون',
                    'unit_price' => 'سعر الوحدة',
                    'no_units' => 'عدد الوحدات',
                ],
            ],
        ],
    ],
    'pharmacy_navigation' => [
        'resource' => 'الصيدليات',
        'list' => 'الصيدليات',
        'edit' => 'تعديل معلومات هذه الصيدلية',
        'view' => 'عرض معلومات هذه الصيدلية',
        'table' => [
            'name' => 'الإسم',
            'logo' => 'اللوجو',
            'carousel' => 'المعرض',
        ],
        'form' => [
            'name' => 'الإسم',
            'logo' => 'اللوجو',
            'carousel' => 'المعرض',
            'p_name' => 'إسم الصيدلية',
            'p_logo' => 'لوجو الصيدلية',
            'p_carousel' => 'معرض الصيدلية',
        ],
    ],
    'about_navigation' => [
        'resource' => 'ماذا عنا',
        'list' => 'ماذا عنا',
        'edit' => 'تعديل صفحة ماذا عنا',
        'view' => 'عرضر صفحة ماذا عنا',
        'table' => [
            'content' => 'المحتوي',
        ],
        'form' => [
            'content' => 'المحتوي',
            'info' => 'معلومات المحتوي',
        ],
    ],
    'faq_navigation' => [
        'resource' => 'الأسئلة الأكثر شيوعا',
        'list' => 'الأسئلة الأكثر شيوعا',
        'edit' => 'تعديل صفحة الأسئلة الأكثر شيوعا',
        'create' => 'إنشاء الأسئلة الأكثر شيوعا',
        'view' => 'عرض صفحة الأسئلة الأكثر شيوعا',
        'table' => [
            'question' => 'السؤال',
            'answer' => 'الجواب',
        ],
        'form' => [
            'question' => 'السؤال',
            'answer' => 'الجواب',
            'info' => 'معلومات الأسئلة الأكثر شيوعا',
        ],
    ],
    'privacy_navigation' => [
        'resource' => 'الخصوصية',
        'list' => 'الخصوصية',
        'create' => 'إنشاء صفحة الخصوصية',
        'edit' => 'تعديل صفحة الخصوصية',
        'view' => 'عرض صفحة الخصوصية',
        'table' => [
            'content' => 'المحتوي',
        ],
        'form' => [
            'content' => 'المحتوي',
            'info' => 'معلومات الخصوصية',
        ],
    ],
    'term_navigation' => [
        'resource' => 'الشروط و الأحكام',
        'list' => 'الشروط و الأحكام',
        'create' => 'إنشاء صفحة الشروط و الأحكام',
        'edit' => 'تعديل صفحة الشروط و الأحكام',
        'view' => 'عرض صفحة الشروط و الأحكام',
        'table' => [
            'key' => 'الحقل',
            'value' => 'القيمة',
        ],
        'form' => [
            'key' => 'الحقل',
            'value' => 'القيمة',
            'info' => 'معلومات الشروط والأحكام',
        ],
    ],
    'offer_navigation' => [
        'resource' => 'العروض',
        'list' => 'العروض',
        'create' => 'إنشاء عرض',
        'edit' => 'تعديل عرض',
        'view' => 'العرض',
        'table' => [
            'name' => 'الإسم',
            'discount_type' => 'نوع الخصم',
            'discount_value' => 'قيمة الخصم',
            'start_date' => 'تاريخ البدء',
            'end_date' => 'تاريخ الإنتهاء',
        ],
        'form' => [
            'info' => 'معلومات العرض',
            'name' => 'الإسم',
            'discount_type' => 'نوع الخصم',
            'discount_value' => 'قيمة الخصم',
            'start_date' => 'تاريخ البدء',
            'end_date' => 'تاريخ الإنتهاء',
            'products' => 'المنتجات',
        ],
    ],
    'order_navigation' => [
        'resource' => 'الطلبات',
        'list' => 'الطلبات',
        'view' => 'الطلب',
        'table' => [
            'user' => 'المستخدم',
            'total_amount' => 'المبلغ الكلي',
            'payment_id' => 'رقم العملية',
            'payment_status' => 'حالة العملية',
            'payment_type' => 'نوع العملية',
        ],
        'form' => [
            'info' => 'معلومات الطلب',
            'user' => 'المستخدم',
            'total_amount' => 'المبلغ الكلي',
            'payment_id' => 'رقم العملية',
            'payment_status' => 'حالة العملية',
            'payment_type' => 'نوع العملية',
        ],
    ],
];
