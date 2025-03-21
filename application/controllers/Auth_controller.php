<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'helpers/jwt_helper.php';


class Auth_controller extends CI_Controller{

    public function index(){
        echo 'auth controller batman'; 
    }

    public function token(){

        $jwt = new JWT();

        $SecretKey = 'leo_key';
        $data = array(
            'user_id' => 1,
            'username' => 'Soorya',
        );

        $token = $jwt->encode($data, $SecretKey, 'HS256');
        echo $token;
    }

    public function decode_token(){
        $token = $this->uri->segment(3);

        $jwt = new JWT();

        $SecretKey = 'leo_key';

        $decoded_token = $jwt->decode($token, $SecretKey, 'HS256');

       // echo '<pre>';
        //print_r($decoded_token);

        $token1 = $jwt->jsonEncode($decoded_token);
        echo $token1;
    }
}