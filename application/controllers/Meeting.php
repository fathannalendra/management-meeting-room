<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meeting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Meeting_model');
        $this->load->model('Room_model');
    }

    public function index()
    {
        $data['title'] = 'Management Ruang Meeting';

        $keyword = $this->input->get('keyword');
        $data['bookings'] = $this->Meeting_model->get_all($keyword);
        $data['rooms'] = $this->Room_model->get_all();
        $data['ongoing_meetings'] = $this->Meeting_model->get_ongoing_meetings();

        $this->load->view('meeting/index', $data);
    }

    // Booking Meeting Room
    public function room()
    {
        $room_id      = $this->input->post('room_id');
        $booked_by    = $this->input->post('booked_by');
        $meeting_date = $this->input->post('meeting_date');
        $start_time   = $this->input->post('start_time');
        $end_time     = $this->input->post('end_time');
        $agenda       = $this->input->post('agenda');

        if (
            empty($room_id) ||
            empty($booked_by) ||
            empty($meeting_date) ||
            empty($start_time) ||
            empty($end_time) ||
            empty($agenda)
        ) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi.');
            redirect('meeting');
        }

        if ($start_time >= $end_time) {
            $this->session->set_flashdata('error', 'Jam selesai harus lebih besar dari jam mulai.');
            redirect('meeting');
        }

        if ($this->Meeting_model->is_conflict($room_id, $meeting_date, $start_time, $end_time)) {
            $this->session->set_flashdata('error', 'Ruangan sudah dibooking pada jadwal tersebut.');
            redirect('meeting');
        }

        $data = [
            'room_id'      => $room_id,
            'booked_by'    => $booked_by,
            'meeting_date' => $meeting_date,
            'start_time'   => $start_time,
            'end_time'     => $end_time,
            'agenda'       => $agenda
        ];

        $this->Meeting_model->insert($data);

        $this->session->set_flashdata('success', 'Booking berhasil ditambahkan.');
        redirect('meeting');
    }

    // VALIDASI EDIT JADWAL APABILA SUDAH MASUK JAM MEETING
    private function is_meeting_started($meeting_date, $start_time)
    {
        $meeting_datetime = strtotime($meeting_date . ' ' . $start_time);
        $now = time();

        return $meeting_datetime <= $now;
    }

    //HALAMAN EDIT BOOKING
    public function edit($id)
    {
        $booking = $this->Meeting_model->get_by_id($id);

        if (!$booking) {
            show_404();
        }

        if ($this->is_meeting_started($booking->meeting_date, $booking->start_time)) {
            $this->session->set_flashdata('error', 'Booking tidak bisa diedit karena jadwal meeting sudah dimulai atau sudah lewat.');
            redirect('meeting');
        }

        $data['title'] = 'Edit Booking';
        $data['booking'] = $booking;
        $data['rooms'] = $this->Room_model->get_all();

        $this->load->view('meeting/edit', $data);
    }

    // UPDATE DATA
    public function update($id)
    {
        $booking = $this->Meeting_model->get_by_id($id);

        if (!$booking) {
            show_404();
        }

        if ($this->is_meeting_started($booking->meeting_date, $booking->start_time)) {
            $this->session->set_flashdata('error', 'Booking tidak bisa diupdate karena jadwal meeting sudah dimulai atau sudah lewat.');
            redirect('meeting');
        }

        $room_id      = $this->input->post('room_id');
        $booked_by    = $this->input->post('booked_by');
        $meeting_date = $this->input->post('meeting_date');
        $start_time   = $this->input->post('start_time');
        $end_time     = $this->input->post('end_time');
        $agenda       = $this->input->post('agenda');

        if (
            empty($room_id) ||
            empty($booked_by) ||
            empty($meeting_date) ||
            empty($start_time) ||
            empty($end_time) ||
            empty($agenda)
        ) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi.');
            redirect('meeting/edit/' . $id);
        }

        if ($start_time >= $end_time) {
            $this->session->set_flashdata('error', 'Jam selesai harus lebih besar dari jam mulai.');
            redirect('meeting/edit/' . $id);
        }

        if ($this->Meeting_model->is_conflict($room_id, $meeting_date, $start_time, $end_time, $id)) {
            $this->session->set_flashdata('error', 'Update gagal, jadwal ruangan bentrok.');
            redirect('meeting/edit/' . $id);
        }

        $data = [
            'room_id'      => $room_id,
            'booked_by'    => $booked_by,
            'meeting_date' => $meeting_date,
            'start_time'   => $start_time,
            'end_time'     => $end_time,
            'agenda'       => $agenda
        ];

        $this->Meeting_model->update($id, $data);

        $this->session->set_flashdata('success', 'Booking berhasil diupdate.');
        redirect('meeting');
    }

    // Delete Booking
    public function delete($id)
    {
        $this->Meeting_model->delete($id);

        redirect('meeting');
    }

    //CEK KETERSEDIAAN RUANGAN
    public function check_availability()
    {
        $room_id      = $this->input->get('room_id');
        $meeting_date = $this->input->get('meeting_date');
        $start_time   = $this->input->get('start_time');
        $end_time     = $this->input->get('end_time');

        if (empty($room_id) || empty($meeting_date) || empty($start_time) || empty($end_time)) {
            $this->session->set_flashdata('error', 'Lengkapi ruangan, tanggal, jam mulai, dan jam selesai untuk cek ketersediaan.');
            redirect('meeting');
        }

        if ($start_time >= $end_time) {
            $this->session->set_flashdata('error', 'Jam selesai harus lebih besar dari jam mulai.');
            redirect('meeting');
        }

        $is_conflict = $this->Meeting_model->is_conflict($room_id, $meeting_date, $start_time, $end_time);

        if ($is_conflict) {
            $this->session->set_flashdata('error', 'Ruangan tidak tersedia pada jadwal tersebut.');
        } else {
            $this->session->set_flashdata('success', 'Ruangan tersedia pada jadwal tersebut.');
        }

        redirect('meeting');
    }
}
