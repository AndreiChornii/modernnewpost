<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author andreichornii
 */
namespace Newpost\Controllers;

use \Ninja\DatabaseTable;

class Register {
    
    private $usersTable;
    
    public function __construct(DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }
    
    public function registrationForm() {
        return ['template' => 'register.html.php',
            'title' => 'Register an account'];
    }
    
    public function registerUser() {
//        var_dump($_POST);
//        var_dump($data);
//        var_dump($_REQUEST);
//        $url = 'data.json'; // path to your JSON file
//        $data = file_get_contents($url); // put the contents of the file into a variable
//        $characters = json_decode($data); // decode the JSON feed
        
        $user = json_decode(file_get_contents('php://input'), true);
//        var_dump($request);
        
        // Assume the data is valid to begin with
        $valid = true;
        $errors = [];
        // But if any of the fields have been left blank
        // set $valid to false
        if (empty($user['email'])) {
            $valid = false;
            $errors[] = 'Email cannot be blank';
        } else if (filter_var($user['email'], FILTER_VALIDATE_EMAIL) == false) {
            $valid = false;
            $errors[] = 'Invalid email address';
        } else { // If the email is not blank and valid:
// convert the email to lowercase
            $user['email'] = strtolower($user['email']);
// Search for the lowercase version of $user['email']
            if (count($this->usersTable->find('email', $user['email'])) > 0) {
                $valid = false;
                $errors[] = 'That email address is already registered';
            }
        }

        if (empty($user['login'])) {
            $valid = false;
            $errors[] = 'user cannot be blank';
        }
        // If $valid is still true, no fields were blank
        // and the data can be added
        if ($valid == true) {
            $this->usersTable->save($user);
//            var_dump($user) ;
            header('Location: /user/success');
        } else {
            // If the data is not valid, show the form again
            return ['template' => 'register.html.php',
                'title' => 'Register an account',
                'variables' => [
                    'errors' => $errors,
                    'user' => $user
                ]
            ];
        }
    }
    
    public function success() {
        return ['template' => 'registersuccess.html.php',
            'title' => 'Registration Successful'];
    }
    
    public function loginUser(){
        $login = $_POST['login'];
        $email = $_POST['email'];
//        var_dump($login);
//        var_dump($email);

        $User = $this->usersTable->find('email', $email);
        
        /* if name or email is not correct
           send page login with error
        
*/
        var_dump($login);
        var_dump($User[0]);
        if(empty($User) || empty($User[0]) || ($login != $User[0]->login) || ($email != $User[0]->email)) {
            $error = 'user not found, enter correct username and email';
//            ECHO $error;
//            include '../templates/login.html.php';
//            include '../templates/layout.html.php';
            $_SESSION['user'] = NULL;
//            header("Location: /");
//            die;
            return ['template' => 'login.html.php',
                'title' => 'Login',
                'variables' => [
                    'errors' => $error,
//                    'user' => $user
                ]
            ];
        }
        
        $_SESSION['user'] = $User[0];

        header("Location: /documents");
    }
    
}
