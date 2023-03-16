<?php

declare(strict_types=1);

namespace User\Service;

use User\Entity\User;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return UserService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): UserService
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $entityManager->getRepository(User::class);

        return new UserService($entityManager, $userRepository);
    }
}
