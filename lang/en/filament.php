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
    'category_navigation' => [

        'resource' => 'Categories',

        'list' => 'Categories',

        'create' => 'Create Category',

        'edit' => 'Edit Category',

        'view' => 'Category',

        'widget' => [
            'total_product_category' => 'Total Products in this Category',
        ],

        'table' => [
            'name' => 'Name',
            'image' => 'Image',
            'export' => 'Export',
        ],

        'form' => [
            'name' => 'Name',
            'image' => 'Image',
            'info' => 'Category Details',
        ],

    ],
    'product_navigation' => [

        'resource' => 'Products',

        'list' => 'Products',
        'create' => 'Create Product',
        'edit' => 'Edit Product',
        'view' => 'Product',

        'widget' => [
            'orders' => 'Orders',
            'favourites' => 'Favourites',
        ],

        'table' => [
            'name' => 'Name',
            'desc' => 'Description',
            'image' => 'Image',
            'barcode' => 'Bar Code',
            'stock' => 'Stock',
            'alert' => 'Alert',
            'unit_price' => 'Unit Price',
            'no_units' => 'No. of Units',
            'export' => 'Export',
        ],

        'form' => [
            'name' => 'Name',
            'desc' => 'Description',
            'image' => 'Product Images',
            'barcode' => 'Barcode',
            'stock' => 'Stock',
            'alert' => 'Alert',
            'unit_price' => 'Unit Price',
            'no_units' => 'No. of Units',
            'info' => 'Product Information',
        ],

        'relation' => [
            'categories' => [
                'form' => [
                    'info' => 'Category Details',
                    'name' => 'Categories',
                    'image' => 'Image',
                ],
                'table' => [
                    'name' => 'Name',
                    'image' => 'Image',
                ],
            ],
            'sideffects' => [
                'form' => [
                    'info' => 'Side Effects Details',
                    'name' => 'Side Effects',
                ],
                'table' => [
                    'name' => 'Name',
                ],
            ],
            'indications' => [
                'form' => [
                    'info' => 'Indications Details',
                    'name' => 'Indications',
                ],
                'table' => [
                    'name' => 'Name',
                ],
            ],
            'offers' => [
                'form' => [
                    'info' => 'Offer Details',
                    'name' => 'Offers',
                    'discount_type' => 'Discount Type',
                    'discount_value' => 'Discount Value',
                    'start_date' => 'Start Date',
                    'end_date' => 'End Date',
                ],
                'table' => [
                    'name' => 'Name',
                    'discount_type' => 'Discount Type',
                    'discount_value' => 'Discount Value',
                    'start_date' => 'Start Date',
                    'end_date' => 'End Date',
                ],
            ],
        ],
    ],
    'indication_navigation' => [

        'resource' => 'Indication',

        'list' => 'Indication',
        'create' => 'Create Indication',
        'edit' => 'Edit Indication',
        'view' => 'Indication',

        'table' => [
            'name' => 'Name',
            'export' => 'Export',
        ],

        'form' => [
            'name' => 'Name',
            'info' => 'Indication Information',
        ],

        'relation' => [
            'products' => [
                'form' => [
                    'info' => 'Product Details',
                    'name' => 'Name',
                    'desc' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Bar Code',
                    'alert' => 'Alert',
                    'stock' => 'Stock',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No. Of Units',
                ],
                'table' => [
                    'name' => 'Name',
                    'desc' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Bar Code',
                    'alert' => 'Alert',
                    'stock' => 'Stock',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No. Of Units',
                ],
            ],
        ],
    ],
    'side_navigation' => [

        'resource' => 'Side Effects',

        'list' => 'Side Effects',
        'create' => 'Create Side Effects',
        'edit' => 'Edit Side Effects',
        'view' => 'Side Effects',

        'table' => [
            'name' => 'Name',
            'export' => 'Export',
        ],

        'form' => [
            'name' => 'Name',
            'info' => 'Side Effect Information',
        ],

        'relation' => [
            'products' => [
                'form' => [
                    'info' => 'Product Details',
                    'name' => 'Name',
                    'desc' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Bar Code',
                    'alert' => 'Alert',
                    'stock' => 'Stock',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No. Of Units',
                ],
                'table' => [
                    'name' => 'Name',
                    'desc' => 'Description',
                    'image' => 'Image',
                    'barcode' => 'Bar Code',
                    'alert' => 'Alert',
                    'stock' => 'Stock',
                    'unit_price' => 'Unit Price',
                    'no_units' => 'No. Of Units',
                ],
            ],
        ],
    ],
    'pharmacy_navigation' => [
        'resource' => 'Pharmacies',
        'list' => 'Pharmacies',
        'edit' => 'Edit Pharmacy',
        'view' => 'Pharmacy',
        'table' => [
            'name' => 'Name',
            'logo' => 'Logo',
            'carousel' => 'Carousel',
        ],
        'form' => [
            'name' => 'Name',
            'logo' => 'Logo',
            'carousel' => 'Carousel',
            'p_name' => 'Pharmacy Name',
            'p_logo' => 'Pharmacy Logo',
            'p_carousel' => 'Pharmacy Carousel',
        ],
    ],
];
