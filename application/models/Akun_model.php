<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun_model extends CI_Model
{
    public function all()
    {
        $data = $this->db->select('*')
            ->from('akun')
            ->get()
            ->result();

        return $data;
    }

    public function status($id, $data)
    {
        $result = $this->db->where('id_akun', $id)
            ->update('akun', $data);

        return $result;
    }

    public function byEmail($kondisi)
    {
        $data = $this->db->select('*')
            ->from('akun')
            ->where('email', $kondisi)
            ->get()
            ->row();

        return $data;
    }

    public function byID($kondisi)
    {
        $data = $this->db->select('*')
            ->from('akun')
            ->where('id_akun', $kondisi)
            ->get()
            ->row();

        return $data;
    }

    public function find($id)
    {
        return $this->db->where('id_akun', $id)
            ->get('akun')->row();
    }

    public function insert($data)
    {
        $result = $this->db->insert('akun', $data);

        return $result;
    }

    public function update($email, $data)
    {
        $result = $this->db->where('email', $email)
            ->update('akun', $data);

        return $result;
    }
}
