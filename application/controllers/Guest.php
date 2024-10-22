<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guest extends CI_Controller
{
    public function index()
    {
        $data = [
            'aktif' => 'beranda'
        ];

        $this->load->view('guest/layout/header', $data);
        $this->load->view('guest/index');
        $this->load->view('guest/layout/footer');
    }

    public function about()
    {
        $data = [
            'aktif' => 'about'
        ];

        $this->load->view('guest/layout/header', $data);
        $this->load->view('guest/about');
        $this->load->view('guest/layout/footer');
    }
}
