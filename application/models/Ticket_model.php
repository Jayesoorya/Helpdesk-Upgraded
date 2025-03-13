<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends CI_Model {
    public function get_all() {
        $query = $this->db->get('tickets');
        return $query->result();
    }
    
    public function get($id) {
        return $this->db->get_where('tickets', ['id' => $id])->row();
    }
    
    public function insert($ticket,$description,$status) {
        $data = [
                  'Ticket' => $ticket,
                  'Description' => $description,
                  'Status' => $status,
    ];
        return $this->db->insert('tickets', $data);
    }
    
    public function update($id, $ticket,$description,$status) {
        $data = [
            'Ticket' => $ticket,
            'Description' => $description,
            'Status' => $status,
];
        return $this->db->where('id', $id)->update('tickets', $data);
    }
    
    public function delete($id) {
        return $this->db->where('id', $id)->delete('tickets');
    }
}

?>