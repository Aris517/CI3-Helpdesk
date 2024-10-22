<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    public function get_messages($pengaduan_id)
    {
        $result = $this->db->where('id_pengaduan', $pengaduan_id)
            ->order_by('tgl', 'ASC')
            ->get('chat')
            ->result();
        return $result;
    }

    public function send_message($data)
    {
        return $this->db->insert('chat', $data);
    }
}
