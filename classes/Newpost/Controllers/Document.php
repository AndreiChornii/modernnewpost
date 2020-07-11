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

    private $documentTable;
//    private $authentication;
//    private $usersTable;

    public function __construct(DatabaseTable $documentTable) {
//        session_start();
        $this->documentTable = $documentTable;
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
            
            
            //            $user = $this->authentication->getUser();
            $request['id_user'] = $_SESSION['id_user'];
            $request['id'] = '';
            
//            var_dump($request);

//            var_dump($this->documentsTable);

            $this->documentTable->save($request);
//            
//            
//            $documents = getDocuments($request['id_user'], $DB);
            $documents = $this->documentTable->find('id_user', $request['id_user']);
//            var_dump($documents);
//            echo json_encode($documents);
//          DELETE  $ttn = getStatus($request);  
//            var_dump($request['ttn']);
            $ttn = $this->getStatus($request);
//            var_dump($ttn);
//
//            if (($documents !== 'Get ttns bad') || ($ttn['rez'] !== 'from new_post bad')) {
//                $documents_and_ttn = [];
//                $documents_and_ttn['documents'] = $documents;
//                $documents_and_ttn['ttn'] = $ttn;
//                echo json_encode($documents_and_ttn);
//            }
            
            $documents_and_ttn = [];
            $documents_and_ttn['documents'] = $documents;
            $documents_and_ttn['ttn'] = $ttn;
            echo json_encode($documents_and_ttn);
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
    
    public function getStatus($data){
        $url_str = 'https://api.novaposhta.ua/v2.0/json/';
        $post_str = '
            {
                "apiKey": "8b9134af8dddb5e26f98be43c5fdf847",
                "modelName": "TrackingDocument",
                "calledMethod": "getStatusDocuments",
                "methodProperties": {
                    "Documents": [
                        {
                            "DocumentNumber": "' . $data['ttn'] . '",
                            "Phone":""
                        }
                    ]
                }

            }
            ';
    //    echo $post_str;
    //    exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str
        );
        $statusDate = curl_exec($ch);
        if (curl_errno($ch)) {
            // print "Error curl: ". curl_error($ch);
            $rezult = "Error curl: " . curl_error($ch);
            $rez = "from new_post bad";
            $to_fe = array(
                'rez' => $rez,
                'rezult' => $rezult
            );
            return $to_fe;
        } else {
            // echo("adr: ");
            //    print_r($adr);
            //    echo("<BR />");
            $decoded = json_decode($statusDate);
    //        var_dump($decoded);
    //        exit();
            $date = 'data';
            $got_array = $decoded->$date;

    //        //элементы ттн
            $ttn_obj = $got_array[0];
    //        var_dump($ttn_obj);
            $sta = 'Status';
            $Status = $ttn_obj->$sta;
            $snd = 'WarehouseSender';
            $WarehouseSender = $ttn_obj->$snd;
            $rcp = 'WarehouseRecipient';
            $WarehouseRecipient = $ttn_obj->$rcp;

    //
            $data = [];

            $data['Status'] = $Status;
            $data['WarehouseSender'] = $WarehouseSender;
            $data['WarehouseRecipient'] = $WarehouseRecipient;

            $data['rez'] = "from new_post ok";
    //       
            return $data;
    //        var_dump($data);
        }
    }

}