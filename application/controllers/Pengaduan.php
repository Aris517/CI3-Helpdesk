<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Controller
{

    private $instance_id;
    private $token;
    private $juber_number;

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('online')) {
            return redirect('auth');
        }

        $this->instance_id = ''; // ganti dengan instance ID UltraMsg Anda
        $this->token = ''; // ganti dengan token UltraMsg Anda
        $this->juber_number = '+62'; // ganti dengan nomor Anda dengan format internasional +62.....
    }

    public function cs($opsi)
    {
        switch ($opsi) {
            case 'baru':
                $this->__CSBaru();
                break;
            case 'proses':
                $this->__CSProses();
                break;
            case 'selesai':
                $this->__CSSelesai();
                break;
            default:
                return redirect();
                break;
        }
    }

    private function __CSBaru()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'id_pengadu' => $this->session->userdata('akun'),
                'status' => 'menunggu'
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('cs/pengaduan/baru/index', $data);
        $this->load->view('layout/footer');
    }

    public function tambah()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $data = [
                'jenis' => $this->jenis->all()
            ];

            $this->load->view('layout/header');
            $this->load->view('cs/pengaduan/baru/tambah', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'id_jenis' => $post['jenis'],
                'isi' => $post['isi'],
                'id_pengadu' => $this->session->userdata('akun'),
            ];

            $jenis = $this->jenis->find($post['jenis']);
            $phone_number = $this->juber_number;
            $message = "*Pengaduan Baru:*\n\n";
            $message .= "Jenis: " . $jenis->jenis . "\n";
            $message .= "Isi: " . $post['isi'] . "\n";
            $message .= "Dari: " . convertToInternationalFormat($this->session->userdata('no_hp')) . "\n\n";
            $message .= "*!!!MOHON LAKUKAN KONFIRMASI SECEPATNYA TERHADAP PENGADU!!!*\n";

            try {
                if ($this->pengaduan->insert($data)) {
                    $this->session->set_flashdata('message', 'Data berhasil disimpan.');
                    $client = new UltraMsg\WhatsAppApi($this->token, $this->instance_id);
                    $to = $phone_number;
                    $message = $message;
                    $client->sendChatMessage($to, $message);
                } else {
                    throw new Exception('Gagal menyimpan data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Gagal menyimpan data atau mengirim pesan WhatsApp. Alasan: ' . $e->getMessage());
            }

            redirect('pengaduan/cs/baru');
        }
    }

    public function ubah($id)
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $data = [
                'pengaduan' => $this->pengaduan->where(['id_pengaduan' => $id])->row(),
                'jenis' => $this->jenis->all()
            ];

            $this->load->view('layout/header');
            $this->load->view('cs/pengaduan/baru/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = [
                'id_jenis' => $post['jenis'],
                'isi' => $post['isi'],
            ];

            try {
                if ($this->pengaduan->update($id, $data)) {
                    $this->session->set_flashdata('message', 'Data berhasil diedit.');
                } else {
                    throw new Exception('Gagal mengedit data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
            }

            redirect('pengaduan/cs/baru');
        }
    }

    public function hapus($id)
    {
        try {
            if ($this->pengaduan->delete($id)) {
                $this->session->set_flashdata('message', 'Data berhasil dihapus.');
            } else {
                throw new Exception('Gagal menghapus data.');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
        }

        redirect('pengaduan/cs/baru');
    }

    public function juber($opsi)
    {
        switch ($opsi) {
            case 'baru':
                $this->__JuberBaru();
                break;
            case 'proses':
                $this->__JuberProses();
                break;
            case 'selesai':
                $this->__JuberSelesai();
                break;
            default:
                break;
        }
    }

    private function __CSProses()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'id_pengadu' => $this->session->userdata('akun'),
                'status' => 'proses'
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('cs/pengaduan/proses/index', $data);
        $this->load->view('layout/footer');
    }

    private function __CSSelesai()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'id_pengadu' => $this->session->userdata('akun'),
                'status' => 'selesai'
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('cs/pengaduan/selesai/index', $data);
        $this->load->view('layout/footer');
    }

    private function __JuberBaru()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'status' => 'menunggu'
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('juber/pengaduan/baru/index', $data);
        $this->load->view('layout/footer');
    }

    private function __JuberProses()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'status' => 'proses',
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('juber/pengaduan/proses/index', $data);
        $this->load->view('layout/footer');
    }

    private function __JuberSelesai()
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'status' => 'selesai'
            ])->result()
        ];

        $this->load->view('layout/header');
        $this->load->view('juber/pengaduan/selesai/index', $data);
        $this->load->view('layout/footer');
    }

    public function konfirmasi($id)
    {
        $pengaduan = $this->pengaduan->find($id);

        if (empty($pengaduan)) {
            $this->session->set_flashdata('error', 'Data pengaduan tidak ditemukan.');
            return redirect('pengaduan/juber/baru');
        } else {
            $data = [
                'status' => 'proses',
                'id_perespon' => $this->session->userdata('akun'),
                'tgl_direspon' => date('Y-m-d H:i:s'),
            ];

            $jenis = $this->jenis->find($pengaduan->id_jenis);

            $phone_number = convertToInternationalFormat($pengaduan->pengadu->no_hp);
            $message = "*Pengaduan Ditanggapi Untuk Aduan:*\n\n";
            $message .= "Jenis: " . $jenis->jenis . "\n";
            $message .= "Isi: " . $pengaduan->isi . "\n";
            $message .= "Dari: " . $this->session->userdata('username') . "\n\n";
            $message .= "*!!!MOHON LAKUKAN PROSES ADUAN PADA MENU PENGADUAN PROSES!!!*\n";

            try {
                if ($this->pengaduan->update($id, $data)) {
                    $client = new UltraMsg\WhatsAppApi($this->token, $this->instance_id);
                    $to = $phone_number;
                    $message = $message;
                    $client->sendChatMessage($to, $message);

                    $this->session->set_flashdata('message', 'Data dikonfirmasi.');
                    return redirect('pengaduan/juber/proses');
                } else {
                    throw new Exception('Gagal dikonfirmasi data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());

                return redirect('pengaduan/juber/baru');
            }
        }
    }

    public function selesai($id)
    {
        $pengaduan = $this->pengaduan->find($id);

        if (empty($pengaduan)) {
            $this->session->set_flashdata('error', 'Data pengaduan tidak ditemukan.');
            return redirect('pengaduan/cs/proses');
        } else {
            $data = [
                'status' => 'selesai',
                'tgl_selesai' => date('Y-m-d H:i:s'),
            ];

            try {
                if ($this->pengaduan->update($id, $data)) {
                    $this->session->set_flashdata('message', 'Status selesai.');
                    return redirect('pengaduan/cs/selesai');
                } else {
                    throw new Exception('Gagal mengubah status data.');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());

                return redirect('pengaduan/juber/baru');
            }
        }
    }

    public function chat($id)
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'id_pengaduan' => $id,
                'status' => 'proses'
            ])->row()
        ];

        $this->load->view('layout/header');
        $this->load->view('chat/index', $data);
        $this->load->view('layout/footer');
    }

    public function detail($id)
    {
        $data = [
            'pengaduan' => $this->pengaduan->where([
                'id_pengaduan' => $id,
                'status' => 'selesai'
            ])->row()
        ];

        $this->load->view('layout/header');
        $this->load->view('chat/detail', $data);
        $this->load->view('layout/footer');
    }
}
