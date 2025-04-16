<?php

class User_model extends CI_Model {
    public function check_login($email, $password) {
        $query = $this->db->get_where('users', ['email' => $email]);
        $user = $query->row();
    
        if ($user && password_verify($password, $user->password)) {
            return $user; 
        }
    
        return false; 
    }
    
    public function get_userdetails($email){
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row();
    }

    public function check_id_email($user_id, $email){
        $query = $this->db->get_where('users', ['user_id' => $user_id, 'email' => $email]);
        return $query->num_rows() > 0;
    }
    
    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_user_by_id($user_id) {
        return $this->db->get_where('users', ['user_id' => $user_id])->row();
    }
    
    public function update_password($user_id, $hashed_password) {
        return $this->db->where('user_id', $user_id)->update('users', ['password' => $hashed_password]);
    }
    

}


?>