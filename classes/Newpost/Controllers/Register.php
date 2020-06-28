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
        $this->authorsTable = $usersTable;
    }
    
    public function registrationForm() {
        return ['template' => 'register.html.php',
            'title' => 'Register an account'];
    }
    
}
