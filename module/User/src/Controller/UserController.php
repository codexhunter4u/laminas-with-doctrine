<?php

declare(strict_types=1);

namespace User\Controller;

use Exception;
use User\Entity\User;
use User\Form\UserForm;
use User\Service\UserService;
use User\Hydrator\UserHydrator;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Paginator\Paginator as LaminasPaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

class UserController extends AbstractActionController
{
    private UserService $userService;

    private UserHydrator $userHydrator;

    /**
     * @param UserService $userService
     * @param UserHydrator $userHydrator
     */
    public function __construct(UserService $userService, UserHydrator $userHydrator)
    {
        $this->userService = $userService;
        $this->userHydrator = $userHydrator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $pageSize = $this->params()->fromQuery('pageSize', 5);
        $query = $this->userService->getPaginationQuery();
        $adapter = new DoctrinePaginatorAdapter(new ORMPaginator($query, false));

        $paginator = new LaminasPaginator($adapter);
        $paginator->setDefaultItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel(
            [
                'users' => $paginator,
                'page' => $page,
                'pageSize' => $pageSize,
            ]
        );
    }

    /**
     * @return ViewModel
     */
     public function addAction(): ViewModel
     {
        $form = new UserForm();
        
        if ($this->getRequest()->isPost()) {
            $formData = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($formData);

            if ($form->isValid()) {
                $user = new User();
                $data = $form->getData();
                $user = $this->userHydrator->hydrate($data, $user);
                $this->userService->saveuser($user);

                return $this->redirect()->toRoute('user');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
     }

    /**
     * @return mixed
     */
    public function editAction()
    {
        $form = new UserForm();
        $userId = (int) $this->params()->fromRoute('id', 0);

        $user = $this->userService->findOneById($userId);
        if ($user == null) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        if ($this->getRequest()->isPost()) {
            $postData = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($postData);

            if ($form->isValid()) {
                $data = $form->getData();
                $user = $this->userHydrator->hydrate($data, $user);
                $this->userService->saveUser($user);

                return $this->redirect()->toRoute('user', ['action' => 'index']);
            }
        } else {
            $form->setData($this->userHydrator->extract($user));
        }

        return new ViewModel([
            'form' => $form,
            'user' => $user
        ]);
    }

    /**
     * @return mixed
     */
    public function deleteAction()
    {
        $userId = (int) $this->params()->fromRoute('id', 0);
        $user = $this->userService->findOneById($userId);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);

            return;
        }

        $this->userService->deleteuser($user);

        return $this->redirect()->toRoute('user', ['action'=>'index']);
    }
}
