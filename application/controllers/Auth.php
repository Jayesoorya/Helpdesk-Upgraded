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
        $this->load->library('form_validation');

    }

    public function login_post() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (!$email || !$password) {
            $this->response([
                'status' => false,
                'message' => 'Email and password are required'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $user = $this->User_model->check_login($email, $password);

        if ($user) {
            // get user details
            $user_details = $this->User_model->get_userdetails($email);
            
            // generate token
            $jwt = new JWT();
            $SecretKey = 'leo_key';
            $data = array(
                'user_id' => $user_details->user_id,
                'email' => $user_details->email 
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
                'message' => 'Invalid email or password'
            ], RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function register_user_post() {

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => false, 'message' => validation_errors()]);
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'email' => $this->input->post('email'),
                'phone_number' => $this->input->post('phone_number'),
            ];
            $this->User_model->insert_user($data);
            echo json_encode(['status' => true, 'message' => 'User registered successfully']);
        }
    }
}

?>
