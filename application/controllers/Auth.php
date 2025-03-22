<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'helpers/jwt_helper.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Auth extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model'); // Load User Model
    }

    public function login_post() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (!$username || !$password) {
            $this->response([
                'status' => false,
                'message' => 'Username and password are required'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $user = $this->User_model->check_login($username, $password);

        if ($user) {
            // get user details
            $user_details = $this->User_model->get_userdetails($username);
            
            // generate token
            $jwt = new JWT();
            $SecretKey = 'leo_key';
            $data = array(
                'user_id' => $user_details->id,
                'username' => $user_details->username
            );
 
            $token = $jwt->encode($data, $SecretKey, 'HS256');
 
            $this->session->set_userdata('user', $user);
            $this->response([
                'status' => true,
                'token' => $token,
                'message' => 'Login successful',
                'redirect' => site_url('dashboard')
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Invalid username or password'
            ], RestController::HTTP_UNAUTHORIZED);
        }
    }
}
?>
