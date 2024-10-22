<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $role = $this->session->userdata('role');
        if (!$this->session->userdata('online')) {
            return redirect('guest');
        }

        if ($role === 'public') {
            $this->load->view('layout/header');
            $this->load->view('cs/index');
            $this->load->view('layout/footer');
        } else {
            $this->load->view('layout/header');
            $this->load->view('juber/index');
            $this->load->view('layout/footer');
        }
    }
}
