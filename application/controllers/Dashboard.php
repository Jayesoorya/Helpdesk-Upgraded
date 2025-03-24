<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'helpers/jwt_helper.php';

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Dashboard extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->model('Ticket_model');
        $this->load->library('form_validation');

        // Ensure user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/login');
        }
    }



    //   Get Tickets (For AJAX)
    public function getTickets_get() {
         //get the token from the headers

         $token = $this->input->get_request_header('Authorization');
        
         $token = str_replace('Bearer ', '', $token);
 
         //decode the jwt token
         try {
             $jwt = new JWT();
             $SecretKey = 'leo_key';
             $decoded =  $jwt->decode($token, $SecretKey, 'HS256');
 
             $user_id = $decoded->user_id;
             $username = $decoded->username;
 
             // validate the jwt token
             $user = $this->User_model->check_id_username($user_id, $username);
     
             if($user){
                $tickets = $this->Ticket_model->get_all();
                if ($tickets) {
                    $this->response(['status' => true, 'tickets' => $tickets], RestController::HTTP_OK);
                } else {
                    $this->response(['status' => false, 'message' => 'No tickets found'], RestController::HTTP_NOT_FOUND);
                }
             }else{
                $this->response(['status' => false, 'message' => 'User Validation failed'], RestController::HTTP_NOT_FOUND);
                    }
        } catch(Exception $e) {
            $this->response(['status' => false, 'message' => 'Invalid token: ' . $e->getMessage()], RestController::HTTP_UNAUTHORIZED);
            return;
        }
}

    //   Get Ticket Details
    public function details_get($id) {
         //get the token from the headers

         $token = $this->input->get_request_header('Authorization');
        
         $token = str_replace('Bearer ', '', $token);
 
         //decode the jwt token
         try {
             $jwt = new JWT();
             $SecretKey = 'leo_key';
             $decoded =  $jwt->decode($token, $SecretKey, 'HS256');
 
             $user_id = $decoded->user_id;
             $username = $decoded->username;
 
             // validate the jwt token
             $user = $this->User_model->check_id_username($user_id, $username);
     
             if($user){
                $ticket = $this->Ticket_model->get($id);
                if ($ticket) {
                    $this->response(['status' => true, 'ticket' => $ticket], RestController::HTTP_OK);
                }
                else{
                    $this->response(['status' => false, 'message' => 'Ticket not found'], RestController::HTTP_NOT_FOUND);
                }
             }
             else{
                $this->response(['status' => false, 'message' => 'User Validation failed'], RestController::HTTP_NOT_FOUND);
             }
        } catch(Exception $e) {
            $this->response(['status' => false, 'message' => 'Invalid token: ' . $e->getMessage()], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    }

    //   Create Ticket (AJAX)
    public function store_post() {
        //get the token from the headers

        $token = $this->input->get_request_header('Authorization');
        
        $token = str_replace('Bearer ', '', $token);

        //decode the jwt token
        try {
            $jwt = new JWT();
            $SecretKey = 'leo_key';
            $decoded =  $jwt->decode($token, $SecretKey, 'HS256');

            $user_id = $decoded->user_id;
            $username = $decoded->username;

            // validate the jwt token
            $user = $this->User_model->check_id_username($user_id, $username);
    
            if ($user) {
                $this->form_validation->set_rules('Ticket', 'Ticket', 'required|min_length[5]');
                $this->form_validation->set_rules('Description', 'Description');
                $this->form_validation->set_rules('Status', 'Status', 'required');
        
                if ($this->form_validation->run() == FALSE) {
                    $this->response(['status' => false, 'message' => validation_errors()], RestController::HTTP_BAD_REQUEST);
                } else {
                    $data = [
                        'Ticket' => $this->input->post('Ticket'),
                        'Description' => $this->input->post('Description'),
                        'Status' => $this->input->post('Status')
                    ];
        
                    $this->Ticket_model->insert($data);
                    $this->response(['status' => true, 'message' => 'Ticket created successfully'], RestController::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => false, 'message' => 'User validation failed'], RestController::HTTP_UNAUTHORIZED);
                return;
            }

        } catch(Exception $e) {
            $this->response(['status' => false, 'message' => 'Invalid token: ' . $e->getMessage()], RestController::HTTP_UNAUTHORIZED);
            return;
        }
       
    }

    //   Update Ticket (AJAX)
    public function update_post($id) {

         //get the token from the headers

         $token = $this->input->get_request_header('Authorization');
        
         $token = str_replace('Bearer ', '', $token);
 
         //decode the jwt token
         try {
             $jwt = new JWT();
             $SecretKey = 'leo_key';
             $decoded =  $jwt->decode($token, $SecretKey, 'HS256');
 
             $user_id = $decoded->user_id;
             $username = $decoded->username;
 
             // validate the jwt token
             $user = $this->User_model->check_id_username($user_id, $username);

             if ($user) {
                $this->form_validation->set_rules('Ticket', 'Ticket', 'required|min_length[5]');
                $this->form_validation->set_rules('Description', 'Description');
                $this->form_validation->set_rules('Status', 'Status', 'required|in_list[Open,In Progress,Closed]');

                if ($this->form_validation->run() == FALSE) {
                    $this->response(['status' => false, 'message' => validation_errors()], RestController::HTTP_BAD_REQUEST);
                } else {
                    $data = [
                        'Ticket' => $this->input->post('Ticket'),
                        'Description' => $this->input->post('Description'),
                        'Status' => $this->input->post('Status')
                    ];

                    $this->Ticket_model->update($id, $data);
                    $this->response(['status' => true, 'message' => 'Ticket updated successfully'], RestController::HTTP_OK);
                }
            }
            else{
                $this->response(['status' => false, 'message' => 'User validation failed'], RestController::HTTP_UNAUTHORIZED);
                return;
            }
    
        } catch(Exception $e) {
            $this->response(['status' => false, 'message' => 'Invalid token: ' . $e->getMessage()], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    }


    //   Delete Ticket (AJAX)
    public function delete_delete($id) {
         //get the token from the headers

         $token = $this->input->get_request_header('Authorization');
        
         $token = str_replace('Bearer ', '', $token);
 
         //decode the jwt token
         try {
             $jwt = new JWT();
             $SecretKey = 'leo_key';
             $decoded =  $jwt->decode($token, $SecretKey, 'HS256');
 
             $user_id = $decoded->user_id;
             $username = $decoded->username;
 
             // validate the jwt token
             $user = $this->User_model->check_id_username($user_id, $username);

            if ($user) {
                if ($this->Ticket_model->delete($id)) {
                    $this->response(['status' => true, 'message' => 'Ticket deleted successfully'], RestController::HTTP_OK);
                } 
                else{
                    $this->response(['status' => false, 'message' => 'Ticket not deleted'], RestController::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'message' => 'Ticket not found'], RestController::HTTP_NOT_FOUND);
            }
        } catch(Exception $e) {
            $this->response(['status' => false, 'message' => 'Invalid token: ' . $e->getMessage()], RestController::HTTP_UNAUTHORIZED);
            return;
        }
}
    

    //   Logout
    public function logout_post() {
        $this->session->unset_userdata('user');
        $this->response(['status' => true, 'message' => 'Logged out successfully'], RestController::HTTP_OK);
    }
}
?>
