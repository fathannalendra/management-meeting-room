<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meeting_model extends CI_Model
{

    private $table = 'meeting_bookings';

    // AMBIL DATA
    public function get_all($keyword = null)
    {
        $this->db->select('meeting_bookings.*, rooms.room_name, rooms.capacity, rooms.facilities');
        $this->db->from($this->table);
        $this->db->join('rooms', 'rooms.id = meeting_bookings.room_id', 'left');
        $this->db->where('meeting_bookings.is_delete', 0);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('rooms.room_name', $keyword);
            $this->db->or_like('meeting_bookings.booked_by', $keyword);
            $this->db->or_like('meeting_bookings.agenda', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('meeting_bookings.id', 'DESC');

        return $this->db->get()->result();
    }

    //JADWAL MEETING ONGOING
    public function get_ongoing_meetings()
    {
        $today = date('Y-m-d');
        $now = date('H:i:s');

        $this->db->select('meeting_bookings.*, rooms.room_name, rooms.capacity');
        $this->db->from($this->table);
        $this->db->join('rooms', 'rooms.id = meeting_bookings.room_id', 'left');
        $this->db->where('meeting_bookings.is_delete', 0);
        $this->db->where('meeting_bookings.meeting_date', $today);
        $this->db->where('meeting_bookings.start_time <=', $now);
        $this->db->where('meeting_bookings.end_time >=', $now);
        $this->db->order_by('meeting_bookings.start_time', 'ASC');

        return $this->db->get()->result();
    }

    // INPUT DATA
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }



    // UPDATE DATA
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [
            'id' => $id,
            'is_delete' => 0
        ])->row();
    }
    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    // HAPUS DATA
    public function delete($id)
    {
        return $this->db->update(
            $this->table,
            ['is_delete' => 1],
            ['id' => $id]
        );
    }



    // VALIDASI JADWAL BENTROK
    public function is_conflict($room_id, $meeting_date, $start_time, $end_time, $exclude_id = null)
    {
        $this->db->where('room_id', $room_id);
        $this->db->where('meeting_date', $meeting_date);
        $this->db->where('is_delete', 0);

        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }

        $this->db->where("start_time < ", $end_time);
        $this->db->where("end_time > ", $start_time);

        return $this->db->get($this->table)->num_rows() > 0;
    }
}
