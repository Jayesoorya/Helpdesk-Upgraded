<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';


use chriskacerguis\RestServer\RestController;

class Auth extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }


    public function loginn(){
        $this->load->view('login_form');
    }
    public function login_post() {
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => false, 'message' => validation_errors()], RestController::HTTP_BAD_REQUEST);
          // $this->load->view('login_form');
        } else {
            $username = $this->post('username');
            $password = $this->post('password');

            if ($user = $this->User_model->check_login($username, $password)) {
                $this->response(['status' => true, 'message' => 'Login successful'], RestController::HTTP_OK);
               // redirect('dashboard');
            } else {
                $this->response(['status' => false, 'message' => 'Invalid credentials'], RestController::HTTP_UNAUTHORIZED);
            }
        }
    }
}
?>
