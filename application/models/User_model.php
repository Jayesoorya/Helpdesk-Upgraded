<?php

class User_model extends CI_Model {
    public function check_login($username, $password) {
        $query = $this->db->get_where('log', ['username' => $username, 'password' => $password]);
        return $query->num_rows() > 0;
    }

    public function get_userdetails($username){
        $query = $this->db->get_where('log', ['username' => $username]);
        return $query->row();
    }

    public function check_id_username($user_id, $username){
        $query = $this->db->get_where('log', ['id' => $user_id, 'username' => $username]);
        return $query->num_rows() > 0;
    }
    
}


?>