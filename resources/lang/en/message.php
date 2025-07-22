<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'internal_server_error' => 'An error occurred on the server. Please try again later',
    'otp_sent' => 'Verification code has been sent',
    'otp_resent' => 'The verification code has been re-sent',
    'otp_sending_blocked' => 'Your number has been blocked for 5 minutes. Please wait',
    'user_inactive' => 'Your account has been deactivated. Please contact the administrator',
    'user_deleted' => 'Your information has been deleted',


    /*
    |--------------------------------------------------------------------------
    | Custom Message Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom messages.
    |
    */

    'custom' => [
        'configuration' => [
            'update' => [
                'basicInfo' => [
                    'success' => 'Company\'s basic information has been updated successfully',
                    'error' => 'Company\'s basic information could not be updated'
                ],
                'additionalInfo' => [
                    'success' => 'Company\'s additional information has been updated successfully',
                    'error' => 'Company\'s additional information could not be updated'
                ],
                'contactInfo' => [
                    'success' => 'Company\'s contact information has been updated successfully',
                    'error' => 'Company\'s contact information could not be updated'
                ],
                'globalInfo' => [
                    'success' => 'Company\'s global information has been updated successfully',
                    'error' => 'Company\'s global information could not be updated'
                ],
                'smsService' => [
                    'success' => 'Company\'s sms service has been updated successfully',
                    'error' => 'Company\'s sms service could not be updated'
                ]
            ]
        ],

        'user' => [
            'store' => [
                'success' => 'New user created successfully',
                'error' => 'New user could not be created'
            ],
            'update' => [
                'basic' => [
                    'success' => 'User\'s information updated successfully',
                    'error' => 'User could not be updated'
                ],
                'profile' => [
                    'success' => 'User\'s profile updated successfully',
                    'error' => 'User\'s profile could not be updated'
                ],
                'updateDetails' => [
                    'success' => 'Details of user updated successfully',
                    'error' => 'Details of user could not be updated'
                ],
                'updateEmail' => [
                    'success' => 'Email of user updated successfully',
                    'error' => 'Email of user could not be updated'
                ],
                'updateRoles' => [
                    'success' => 'Roles of user updated successfully',
                    'error' => 'Roles of user could not be updated'
                ],
                'updatePassword' => [
                    'success' => 'Password updated successfully',
                    'error' => 'Password could not be updated'
                ]
            ],
            'destroy' => [
                'success' => 'User deleted successfully',
                'error' => 'User could not be deleted'
            ],
            'changeStatus' => [
                'activate' => 'User is activated',
                'deactivate' => 'User is deactivated'
            ]
        ],

        'role' => [
            'store' => [
                'success' => 'New role created successfully',
                'error' => 'New role could not be created'
            ],
            'update' => [
                'success' => 'Role and permission updated successfully',
                'error' => 'Role and permission could not be updated'
            ],
            'destroy' => [
                'basic' => [
                    'success' => 'Role and permission deleted successfully',
                    'error' => 'Role and permission could not be deleted',
                ],
                'removeUserFromRole' => [
                    'success' => 'User removed from role successfully',
                    'error' => 'User removed from role could not be deleted'
                ]
            ],
            'changeStatus' => [
                'activate' => 'Role is activated',
                'deactivate' => 'Role is deactivated',
                'error' => 'Super admin status can not be changed'
            ]
        ],

        'brand' => [
            'store' => [
                'success' => 'Brand is created successfully',
                'error' => 'Brand could not be created'
            ],
            'update' => [
                'success' => 'Brand is updated successfully',
                'error' => 'Brand could not be updated'
            ],
            'destroy' => [
                'success' => 'Brand is deleted successfully',
                'error' => 'Brand could not be deleted'
            ],
            'changeStatus' => [
                'activate' => 'Brand is activated',
                'deactivate' => 'Brand is deactivated',
                'error' => 'Brand status could not be changed'
            ]
        ],
    ]
];
