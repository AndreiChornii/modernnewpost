<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Newpost\Controllers;

use \Ninja\DatabaseTable;
//use \Ninja\Authentication;

class Document {

    private $documentsTable;
//    private $authentication;
//    private $usersTable;

    public function __construct(DatabaseTable $documentsTable) {
        $this->documentsTable = $documentsTable;
//        $this->authentication = $authentication;
//        $this->usersTable = $usersTable;
    }
    
    public function documentsForm(){
        return ['template' => 'documents.html.php', 
                'title' => 'Documents'];
    }
    
    public function getDocuments() {
//        return ['template' => 'loginsuccess.html.php', 
//                'title' => 'getDocuments'];
//        echo '11111111111111111111111111';
        $request = json_decode(file_get_contents('php://input'), true);
//        var_dump($request);
//
        $isValid = $this->validTtn($request);
//        var_dump($isValid);

        if ($isValid['rezult']) {
            
            $user = $this->authentication->getUser();
            $request['id_user'] = $user;
            $request['id'] = '';
            
            var_dump($request);

//            $this->documentsTable->save($request);
//            
//            
//            $documents = getDocuments($request['id_user'], $DB);
//            $ttn = getStatus($request);
//
//            if (($documents !== 'Get ttns bad') || ($ttn['rez'] !== 'from new_post bad')) {
//                $documents_and_ttn = [];
//                $documents_and_ttn['documents'] = $documents;
//                $documents_and_ttn['ttn'] = $ttn;
//                echo json_encode($documents_and_ttn);
//            }
        } else {
            $response = [
                'result' => false,
                'message' => $isValid['errors']
            ];

            echo json_encode($response);
        }
    }
    
    public function validTtn($data){
        $errors = [];

        if (!preg_match('/^[0-9]{14}$/i', $data['ttn'])) {
            $errors['ttn'] = 'ttn is not valid';
        }

        if ($errors) {
            $response = [
                'rezult' => false,
                'errors' => $errors
            ];
            return $response;
        }
        $response = [
            'rezult' => true
        ];
        return $response;
    }

    private function valid($data) {

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

}