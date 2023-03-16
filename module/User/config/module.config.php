<?php

namespace User;

use User\Service\UserService;
use User\Hydrator\UserHydrator;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use User\Service\UserServiceFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/user[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'user_entity' => [
                'class' => AnnotationDriver::class,
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'User\Entity' => 'user_entity',
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            UserHydrator::class => UserHydrator::class,
        ],
        'factories' => [
            UserService::class => UserServiceFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\UserController::class => Controller\UserControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
