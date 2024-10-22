<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('online') && $this->session->userdata('role')  !== 'cs') {
            return redirect('auth');
        }
    }

    public function kategori()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $data = [
                'jenis' => $this->jenis->all()
            ];

            $this->load->view('layout/header');
            $this->load->view('juber/laporan/kategori', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'opsi' =>  $this->jenis->find($post['jenis'])->jenis,
                'pengaduan' => $this->pengaduan->where(['id_jenis' => $post['jenis']])->result(),
            ];

            $this->load->view('juber/laporan/cetak/kategori', $data);
        }
    }

    public function periode()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $this->load->view('layout/header');
            $this->load->view('juber/laporan/periode');
            $this->load->view('layout/footer');
        } else {
            $data = [
                'dari' => $post['dari'],
                'sampai' => $post['sampai'],
                'pengaduan' => $this->pengaduan->where(['tgl_masuk >=' => date('Y-m-d 00:00:00', strtotime($post['dari'])), 'tgl_masuk <=' => date('Y-m-d 23:59:59', strtotime($post['sampai']))])->result(),
            ];

            $this->load->view('juber/laporan/cetak/periode', $data);
        }
    }
}
