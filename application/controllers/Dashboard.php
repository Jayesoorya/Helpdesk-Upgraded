+<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';


use chriskacerguis\RestServer\RestController;

class Dashboard extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Ticket_model');
        $this->load->library('form_validation');
    }

    
    public function index_get() {
        $tickets = $this->Ticket_model->get_all();
        if ($tickets) {
           // $this->response(['status' => true, 'tickets' => $tickets], RestController::HTTP_OK);
            $this->load->view('home', ['tickets' =>$tickets]);
        } else {
            $this->response(['status' => false, 'message' => 'No tickets found'], RestController::HTTP_NOT_FOUND);
        }
    }

    
    public function details_get($id) {
        $ticket = $this->Ticket_model->get($id);
        if ($ticket) {
           // $this->response(['status' => true, 'ticket' => $ticket], RestController::HTTP_OK);
            $this->load->view('details',['status' => true, 'ticket' => $ticket]);
        } else {
            $this->response(['status' => false, 'message' => 'Ticket not found'], RestController::HTTP_NOT_FOUND);
        }
    }


    public function store_post() {
        $this->form_validation->set_rules('Ticket', 'Ticket', 'required|min_length[5]');
        $this->form_validation->set_rules('Description', 'Description');
        $this->form_validation->set_rules('Status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => false, 'message' => validation_errors()], RestController::HTTP_BAD_REQUEST);
        } else {
            $ticket = $this->input->post('Ticket');
            $description = $this->input->post('Description');
            $status = $this->input->post('Status');

            $this->Ticket_model->insert($ticket,$description,$status);
               
            $this->response(['status' => true, 'message' => 'Ticket created successfully'], RestController::HTTP_CREATED);
            redirect('dashboard');
        }
    }

    
    public function update_post($id) {
        $this->form_validation->set_rules('Ticket', 'Ticket', 'required|min_length[5]');
        $this->form_validation->set_rules('Description', 'Description');
        $this->form_validation->set_rules('Status', 'Status', 'required|in_list[Open,In Progress,Closed]');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => false, 'message' => validation_errors()], RestController::HTTP_BAD_REQUEST);
        } else {
            $ticket = $this->input->post('Ticket');
            $description = $this->input->post('Description');
            $status = $this->input->post('Status');

            $this->Ticket_model->update($id,$ticket,$description,$status);
            $this->response(['status' => true, 'message' => 'Ticket updated successfully'], RestController::HTTP_OK);
            redirect('dashboard');
        }
    }


    public function delete_delete($id) {
        if ($this->Ticket_model->delete($id)) {
            $this->response(['status' => true, 'message' => 'Ticket deleted successfully'], RestController::HTTP_OK);
            redirect('dashboard');
        } else {
            $this->response(['status' => false, 'message' => 'Ticket not found'], RestController::HTTP_NOT_FOUND);
        }
    }
}
?>
