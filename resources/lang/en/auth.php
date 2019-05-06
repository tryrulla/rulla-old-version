<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'dropdown' => [
        'title' => 'Authentication',
        'login' => [
            'title' => 'Login',
            'desc' => 'If you already have an account, you may log in here.'
        ],
        'register' => [
            'title' => 'Register',
            'desc' => 'If you want to create a new account, start here.'
        ]
    ],

    'forms' => [
        'login' => [
            'title' => 'Log in',

            'fields' => [
                'identity' => [
                    'title' => 'Username or email',
                    'placeholder' => 'johndoe or johndoe@gmail.com'
                ],

                'password' => [
                    'title' => 'Password',
                    'placeholder' => '●●●●●●●●●●●●●●●●●●●●'
                ],

                'remember' => 'Remember me'
            ],

            'button' => 'Go ahead',
            'register' => 'Need an account?',
            'forgot' => 'Forgot password?'
        ],

        'register' => [
            'title' => 'Register',

            'fields' => [
                'username' => [
                    'title' => 'Username',
                    'placeholder' => 'johndoe'
                ],

                'email' => [
                    'title' => 'E-mail',
                    'placeholder' => 'johndoe@company.org'
                ],

                'password' => [
                    'title' => 'Password',
                    'placeholder' => '●●●●●●●●●●●●●●●●●●●●'
                ],

                'confirm' => [
                    'title' => 'Password confirmation',
                    'placeholder' => '●●●●●●●●●●●●●●●●●●●●'
                ]
            ],

            'button' => 'Create account',
            'login' => 'Log in instead'
        ],

        'request-reset' => [
            'title' => 'Request new password',

            'fields' => [
                'email' => [
                    'title' => 'E-mail',
                    'placeholder' => 'johndoe@company.org'
                ],
            ],

            'button' => 'E-mail me the link',
            'login' => 'Log in'
        ],

        'reset' => [
            'title' => 'Reset password',

            'fields' => [
                'email' => [
                    'title' => 'E-mail',
                    'placeholder' => 'johndoe@company.org'
                ],

                'password' => [
                    'title' => 'Password',
                    'placeholder' => '●●●●●●●●●●●●●●●●●●●●'
                ],

                'confirm' => [
                    'title' => 'Password confirmation',
                    'placeholder' => '●●●●●●●●●●●●●●●●●●●●'
                ]
            ],

            'button' => 'Change my password'
        ]
    ],

    'logout' => 'Log out',

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

];
