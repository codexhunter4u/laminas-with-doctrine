<?php

declare(strict_types=1);

namespace User\Service;

use User\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use User\Repository\UserRepository;

class UserService
{
    private EntityManager $entityManager;

    private UserRepository $userRepository;

    /**
     * @param EntityManager $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(EntityManager $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @return Query
     */
    public function getPaginationQuery(): Query
    {
        return $this->userRepository->getPaginationQuery();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
