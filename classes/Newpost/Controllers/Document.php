<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Newpost\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Document {

    private $documentsTable;
    private $usersTable;

    public function __construct(DatabaseTable $documentsTable, DatabaseTable $usersTable) {
        $this->documentsTable = $documentsTable;
        $this->usersTable = $usersTable;
        }
        
}