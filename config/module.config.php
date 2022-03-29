<?php

namespace Cas;

return [
    'cas' => [
        // This should be configured in Omeka config/local.config.php
        'adapter_options' => [
        'cas_server' => 'https://your.cas.server',
        'cas_login_path' => '/cas/login',
        'cas_validate_path' => '/cas/serviceValidate',
        'cas_service' => 'https://your.omeka.site/cas-login',
        'cas_email_domain' => 'your.email.domain',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Omeka\AuthenticationService' => Service\Authentication\AuthenticationServiceFactory::class,
        ],
    ],
    'controllers' => [
    'factories' => [
        'Cas\Controller\Login' => Service\Controller\LoginControllerFactory::class,
    ]
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        '__NAMESPACE__' => 'Cas\Controller',
                        'controller' => 'login',
                        'action' => 'cas'
                    ]
                ]
            ],
            'cas-login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/cas-login',
                    'defaults' => [
                        '__NAMESPACE__' => 'Cas\Controller',
                        'controller' => 'login',
                        'action' => 'casAuth'
                    ]
                ]
            ]
        ]
    ]
];
