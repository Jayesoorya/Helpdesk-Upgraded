<?php

class User_model extends CI_Model {
    public function check_login($username, $password) {
        $query = $this->db->get_where('log', ['username' => $username, 'password' => $password]);
        return $query->num_rows() > 0;
    }
}


?>