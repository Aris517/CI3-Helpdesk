<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller
{
    public function get_message()
    {
        $pengaduan_id = $this->input->post('pengaduan');
        $messages = $this->chat->get_messages($pengaduan_id);
        echo json_encode(['messages' => $messages]);
    }

    public function get_role_pengirim()
    {
        $pengirim_id = $this->input->post('pengirim');
        $pengirim = $this->akun->find($pengirim_id);
        echo json_encode(['akun' => $pengirim]);
    }
    public function send_message()
    {
        $message = $this->input->post('message');
        $pengaduan_id = $this->input->post('pengaduan');
        $user_id = $this->session->userdata('akun');

        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $pengaduan = $this->pengaduan->find($pengaduan_id);

        $data = [
            'id_pengirim' => $user_id,
            'id_penerima' => $pengaduan->id_perespon,
            'id_pengaduan' => $pengaduan_id,
            'isi' => nl2br($message)
        ];

        $success = $this->chat->send_message($data);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
