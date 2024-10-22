<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis extends CI_Controller
{
    public function index()
    {
        $data = [
            'jenis' => $this->jenis->all()
        ];

        $this->load->view('layout/header');
        $this->load->view('juber/jenis/index', $data);
        $this->load->view('layout/footer');
    }

    public function tambah()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $this->load->view('layout/header');
            $this->load->view('juber/jenis/tambah');
            $this->load->view('layout/footer');
        } else {
            $data = [
                'jenis' => $post['jenis'],
            ];

            try {
                if ($this->jenis->insert($data)) {
                    $this->session->set_flashdata('message', 'Data berhasil disimpan.');
                } else {
                    throw new Exception('Gagal menyimpan data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
            }

            redirect('jenis');
        }
    }

    public function ubah($id)
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $data = [
                'jenis' => $this->jenis->find($id)
            ];

            $this->load->view('layout/header');
            $this->load->view('juber/jenis/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'jenis' => $post['jenis'],
            ];

            try {
                if ($this->jenis->update($id, $data)) {
                    $this->session->set_flashdata('message', 'Data berhasil diupdate.');
                } else {
                    throw new Exception('Gagal mengupdate data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
            }

            redirect('jenis');
        }
    }

    public function hapus($id)
    {
        try {
            if ($this->jenis->delete($id)) {
                $this->session->set_flashdata('message', 'Data berhasil dihapus.');
            } else {
                throw new Exception('Gagal menghapus data.');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
        }

        redirect('jenis');
    }
}
