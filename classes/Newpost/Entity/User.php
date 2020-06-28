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
namespace Newpost\Entity;

class User {
    
    public $id;
    public $login;
    public $email;
    private $documentsTable;
    
    public function __construct(\Ninja\DatabaseTable $documentsTable) {
        $this->documentsTable = $documentsTable;
    }
      
    
    
}
