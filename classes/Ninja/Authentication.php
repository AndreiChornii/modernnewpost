<?php

namespace Ninja;

class Authentication {

    private $users;
    private $usernameColumn;
    private $emailColumn;

    public function __construct(DatabaseTable $users, $usernameColumn, $emailColumn) {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->emailColumn = $emailColumn;
    }

    public function login($username, $email) {
        $user = $this->users->find($this->usernameColumn, strtolower($username));
//        var_dump($user);
//        var_dump($this->usernameColumn);
//        var_dump($this->emailColumn);
        if (!empty($user) && ($email === $user[0]->{$this->emailColumn})) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $user[0]->{$this->emailColumn};
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn() {
//        if (empty($_SESSION['username'])) {
//            return false;
//        }
        if ($_SESSION['username'] === 'logout') {
            return false;
        }
        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
        $passwordColumn = $this->passwordColumn;
        
        if (!empty($user) && $user[0]->$passwordColumn === $_SESSION['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser() {
        if ($this->isLoggedIn()) {
            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
        } else {
            return false;
        }
    }

}
