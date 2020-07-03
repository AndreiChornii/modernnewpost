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
    private $documentsTable;
    
    public function __construct(\Ninja\DatabaseTable $documentsTable) {
        $this->documentsTable = $documentsTable;
    }
    
    public function validTtn($data){
        $errors = [];

        if (!preg_match('/^[а-яa-z0-9\-_\.]{5,25}$/i', $data['name'])) {
            $errors['name'] = 'name is not valid';
        }
        // var_dump($data);
        if (!preg_match('/^[0-9a-z.\-_]{1,15}@[0-9a-z.\-_]{1,14}\.[a-z.\-_]{1,10}$/i', $data['email'])) {
            $errors['email'] = 'email is not valid';
        }

        if ($errors) {
            return $errors;
        }
        return true;
    }
    
//    public function validTtn($data){
//        $ttn = $data['ttn'];
//        $id_user = $data['id_user'];
//        
//        
//        $this->documentsTable->save($data);
//    }
    
}