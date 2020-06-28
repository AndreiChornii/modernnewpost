<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Newpost\Entity;

class Documents{
    public $id;
    public $ttn;
    public $id_user;
    private $usersTable;
    
    public function __construct(\Ninja\DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }
    
}