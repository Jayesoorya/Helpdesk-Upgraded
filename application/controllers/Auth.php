<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

        $user = $this->User_model->check_credentials($username, $password);

        if ($user) {
            $this->session->set_userdata('user', $user);
            $this->response([
                'status' => true,
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
