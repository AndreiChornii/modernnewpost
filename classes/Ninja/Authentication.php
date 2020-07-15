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
            $_SESSION['id_user'] = $user[0]->id;
//            var_dump($_SESSION);
            return true;
        } else {
            return false;
        }
    }
    
    public function logout() {
        $_SESSION['username'] = null;
        $_SESSION['email'] = null;
        $_SESSION['id_user'] = null;
//        echo 'llllllllllll';
    }

    public function isLoggedIn() {
//        if (empty($_SESSION['username'])) {
//            return false;
//        }
        if ($_SESSION['username'] === null) {
            return false;
        }
        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
        $emailColumn = $this->emailColumn;
        
        if (!empty($user) && $user[0]->$emailColumn === $_SESSION['email']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser() {
        if ($this->isLoggedIn()) {
//            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
        } else {
            return false;
        }
    }

}
