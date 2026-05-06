<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_model extends CI_Model {

    private $table = 'rooms';

    public function get_all()
    {
        $this->db->where('is_delete', 0);
        $this->db->order_by('room_name', 'ASC');
        return $this->db->get($this->table)->result();
    }
}