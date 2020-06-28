<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ninja;

/**
 * Description of Api
 *
 * @author andreichornii
 */
class Api {

    private $url_str;
    private $post_str;

    public function __construct(string $url_str, string $post_str) {
        $this->url_str = $url_str;
        $this->post_str = $post_str;
    }

    public function getData() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_str
        );
        $gotDate = curl_exec($ch);
        if (curl_errno($ch)) {
            // print "Error curl: ". curl_error($ch);
            $rezult = "Error curl: " . curl_error($ch);
            $rez = "from_api_bad";
            $to_fe = array(
                'rez' => $rez,
                'rezult' => $rezult
            );
            return $to_fe;
        } else {
            $decoded = json_decode($gotDate);
          return $decoded;
        }
    }
    
}
    