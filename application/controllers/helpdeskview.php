<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class helpdeskview extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ticket_model');
        $this->load->library('session');
    }

    public function loginview(){
        $header_data['title'] = 'Login';
        $this->load->view('header', $header_data);
        $this->load->view('login_form');
        $this->load->view('footer');
    }

    public function dashboard() {
        $header_data['title'] = 'Home';
        $this->load->view('header', $header_data);
        $this->load->view('home');
        $this->load->view('footer');

    }
    public function details($id){
        $header_data['title'] = 'Details Page';
        $this->load->view('header', $header_data);
        $this->load->view('details');
        $this->load->view('footer');

    }

    public function sign_up(){
        $header_data['title'] = 'Register';
        $this->load->view('header', $header_data);
        $this->load->view('sign_up');
        $this->load->view('footer');
    }

    public function profile(){
        $header_data['title'] = 'Profile';
        $this->load->view('header', $header_data);
        $this->load->view('profile_page');
        $this->load->view('footer');
    }
}