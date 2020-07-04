<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Newpost\Entity;

class Document{
    public $id;
    public $ttn;
    public $id_user;
    private $documentsTable;
    
    public function __construct(\Ninja\DatabaseTable $documentsTable) {
        $this->documentsTable = $documentsTable;
    }
    
    
//    public function validTtn($data){
//        $ttn = $data['ttn'];
//        $id_user = $data['id_user'];
//        
//        
//        $this->documentsTable->save($data);
//    }
    
}