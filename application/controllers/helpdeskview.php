<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class helpdeskview extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ticket_model');
        $this->load->library('session');
    }

    public function loginview(){
        $this->load->view('login_form');
    }

    public function dashboard() {
      //  $tickets = $this->Ticket_model->get_all();
        $this->load->view('home');
    }
    public function details($id){
        $this->load->view('details');
    }
}