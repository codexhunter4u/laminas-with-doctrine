<?php

declare(strict_types=1);

namespace User\Controller;

use User\Hydrator\UserHydrator;
use User\Service\UserService;
use User\Controller\UserController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return UserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): UserController
    {
        return new UserController(
            $container->get(UserService::class),
            $container->get(UserHydrator::class)
        );
    }
}
