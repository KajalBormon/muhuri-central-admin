<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom breadcrumbs.
    |
    */

    'custom' => [
        'configuration' => [
            'parentInfo' => 'Settings',
            'childInfo' => [
                'basicInfo' => 'Basic Information',
                'additionalInfo' => 'Additional Information',
                'contactInfo' => 'Contact Information',
                'globalInfo' => 'Global Information',
                'smsService' => 'SMS Service'
            ]
        ],
        'user' => [
            'parentInfo' => 'User Management',
            'childInfo' => [
                'index' => 'Users',
                'create' => 'Add',
                'edit' => 'Edit',
                'details' => 'Details',
                'profile' => 'Profile'
            ]
        ],
        'role' => [
            'childInfo' => [
                'index' => 'Roles',
                'create' => 'Add',
                'edit' => 'Edit',
                'details' => 'Details'
            ]
        ],
        'permission' => [
            'childInfo' => [
                'index' => 'Permissions',
                'create' => 'Add',
                'edit' => 'Edit'
            ]
        ],
        'brand' => [
            'parentInfo' => 'Brands',
            'childInfo' => [
                'index' => 'Brand List',
                'create' => 'Add',
                'edit' => 'Edit',
            ]
        ],

    ]
];
