<?php

namespace Newpost;

class NewpostRoutes implements \Ninja\Routes {

    private $documentsTable;
    private $usersTable;
    private $authentication;

    public function __construct() {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->documentsTable = new \Ninja\DatabaseTable($pdo, 'documents', 'id', '\Newpost\Entity\Document', [&$this->usersTable]);
        $this->usersTable = new \Ninja\DatabaseTable($pdo, 'users', 'id', '\Newpost\Entity\User', [&$this->documentsTable]);
        $this->authentication = new \Ninja\Authentication($this->usersTable, 'login', 'email');
    }

    public function getRoutes(): array {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

//        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
//        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        $documentController = new \Newpost\Controllers\Document($this->documentsTable, $this->usersTable);
        $userController = new \Newpost\Controllers\Register($this->usersTable);
        $loginController = new \Newpost\Controllers\Login($this->authentication);

        $routes = [
            'user/register' => [
                'GET' => [
                    'controller' => $userController,
                    'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $userController,
                    'action' => 'registerUser'
                ]
            ],
            'user/success' => [
                'GET' => [
                    'controller' => $userController,
                    'action' => 'success'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success'
                ],
                'login' => true
            ],
//            'documents' => [
//                'GET' => [
//                    'controller' => $userController,
//                    'action' => 'success'
//                ]
//            ],
        ];

        return $routes;
    }

    public function getAuthentication(): \Ninja\Authentication {
        return $this->authentication;
    }

    public function checkPermission($permission): bool {
        $user = $this->authentication->getUser();
        if ($user && $user->hasPermission($permission)) {
            return true;
        } else {
            return false;
        }
    }

}
