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
    
    public function insert($data) {
        $data = [
                  'Ticket' => $this->input->post('Ticket'),
                  'Description' => $this->input->post('Description'),
                  'Status' => $this->input->post('Status'),
    ];
        return $this->db->insert('tickets', $data);
    }
    
    public function update($id, $data) {
        $data = [
            'Ticket' => $this->input->post('Ticket'),
            'Description' => $this->input->post('Description'),
            'Status' => $this->input->post('Status'),
];
        return $this->db->where('id', $id)->update('tickets', $data);
    }
    
    public function delete($id) {
        return $this->db->where('id', $id)->delete('tickets');
    }
}

?>