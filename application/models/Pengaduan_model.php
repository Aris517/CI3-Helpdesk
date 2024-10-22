<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan_model extends CI_Model
{
    public function all()
    {
        $result =  $this->db->get('pengaduan')->result();

        foreach ($result as &$row) {
            $row->jenis = $this->jenis->find($row->id_jenis);
            $row->pengadu = $this->akun->find($row->id_pengadu);
            $row->perespon = $this->akun->find($row->id_perespon);
        }

        return $result;
    }

    public function where($data)
    {
        if ($this->session->userdata('role') !== 'cs') {
            $this->db->order_by('id_perespon', $this->session->userdata('akun'));
        }
        $this->db->order_by('tgl_masuk', 'asc');
        $result = $this->db->get_where('pengaduan', $data);

        foreach ($result->result() as &$row) {
            $row->jenis = $this->jenis->find($row->id_jenis);
            $row->pengadu = $this->akun->find($row->id_pengadu);
            $row->perespon = $this->akun->find($row->id_perespon);
        }

        return $result;
    }

    public function insert($data)
    {
        $result = $this->db->insert('pengaduan', $data);

        return $result;
    }

    public function find($id)
    {
        $row = $this->db->where('id_pengaduan', $id)
            ->get('pengaduan')->row();

        $row->jenis = $this->jenis->find($row->id_jenis);
        $row->pengadu = $this->akun->find($row->id_pengadu);
        $row->perespon = $this->akun->find($row->id_perespon);

        return $row;
    }

    public function delete($id)
    {
        $result = $this->db->where('id_pengaduan', $id)
            ->delete('pengaduan');

        return $result;
    }

    public function update($id, $data)
    {
        $result = $this->db->where('id_pengaduan', $id)
            ->update('pengaduan', $data);

        return $result;
    }
}
