<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_model extends CI_Model
{
    public function all()
    {
        return $this->db->get('jenis')->result();
    }

    public function insert($data)
    {
        $result = $this->db->insert('jenis', $data);

        return $result;
    }

    public function find($id)
    {
        $result = $this->db->where('id_jenis', $id)
            ->get('jenis')->row();

        return $result;
    }

    public function delete($id)
    {
        $result = $this->db->where('id_jenis', $id)
            ->delete('jenis');

        return $result;
    }

    public function update($id, $data)
    {
        $result = $this->db->where('id_jenis', $id)
            ->update('jenis', $data);

        return $result;
    }
}
