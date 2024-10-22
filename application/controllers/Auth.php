<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('online')) {
            $this->__logout();
        }
    }

    public function index()
    {
        if (!$this->session->userdata('online')) {
            $this->__login();
        }
    }

    private function __login()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $this->load->view('auth/login');
        } else {
            $akun = $this->akun->byEmail($post['email']);

            if (!empty($akun)) {
                if (password_verify($this->input->post('password'), $akun->password)) {
                    if ($akun->verify) {
                        if ($akun->status == 'aktif') {
                            $userdata = [
                                'akun' => $akun->id_akun,
                                'username' => $akun->username,
                                'email' => $akun->email,
                                'no_hp' => $akun->no_hp,
                                'role' => $akun->role,
                                'status' => $akun->status,
                                'online' => true,
                            ];

                            $this->session->set_userdata($userdata);

                            return redirect('home');
                        } else {
                            $this->session->set_flashdata(
                                'pesan',
                                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    Akun anda telah dinonaktifkan!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>'
                            );
                            return redirect('auth');
                        }
                    } else {
                        $this->__verifikasi($akun->email);
                    }
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email atau password salah!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
                    );
                    return redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email atau password salah!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                );
                return redirect('auth');
            }
        }
    }

    public function registrasi()
    {
        $post = $this->input->post(null, true);

        if (empty($post)) {
            $this->load->view('auth/registrasi');
        } else {
            if ($post['password'] !== $post['k_password']) {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Konfirmasi password tidak sinkron dengan password!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                );
                return redirect('auth/registrasi');
            } else {
                $akun = $this->akun->byEmail($post['email']);

                if (!empty($akun)) {
                    if ($akun->status === 'nonaktif' && $akun->verify === false) {
                        $this->__verifikasi($post['email']);
                    }
                }

                $this->form_validation->set_rules('email', 'Email', 'is_unique[akun.email]');

                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Email telah digunakan atau belum diverifikasi!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
                    );
                    return redirect('auth/registrasi');
                } else {
                    $data = [
                        'username' => $post['username'],
                        'email' => $post['email'],
                        'no_hp' => $post['no_hp'],
                        'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                    ];

                    $result = $this->akun->insert($data);

                    $id_user = $this->db->insert_id();

                    if ($result) {
                        $for = generate_sha256_hash($post['email']);

                        $to                 = $post['email'];
                        $subject            = "Account Verification";

                        $message            = '
                                <h1 style="margin-bottom:30px; text-align:center;">Account Verification</h1>
                                <p style="margin-bottom:30px; text-align:center;">Silahkan lakukan step berikut ini untuk memverifikasi akun anda!</p>
                                <center>
                                <a href="' . base_url('auth/verify_proses/' . $id_user . '/' . $for) . '">Verifikasi</a>
                                </center>
                                <p style="margin-top:50px; text-align:center;">PPDB</p>
                        ';

                        $mail = new PHPMailer(true);

                        try {
                            $mail->SMTPDebug = SMTP::DEBUG_OFF;
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.googlemail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''; // ubah dengan alamat email Anda
                            $mail->Password   = ''; // ubah dengan app password yang telah diuat
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port       = 465;

                            $mail->setFrom('', ''); // ubah dengan alamat email Anda, nama anda
                            $mail->addAddress($to);
                            $mail->addReplyTo('', ''); // ubah dengan alamat email Anda, nama anda

                            // Isi Email
                            $mail->isHTML(true);
                            $mail->Subject = $subject;
                            $mail->Body    = $message;

                            $mail->send();
                        } catch (Exception $e) {
                            $this->session->set_flashdata(
                                'email',
                                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    ' . $mail->ErrorInfo . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>'
                            );
                            return redirect('auth/registrasi');
                        }

                        $this->__verifikasi($post['email']);
                    } else {
                        $this->session->set_flashdata(
                            'pesan',
                            '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Pendaftaran gagal silahkan coba lagi!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>'
                        );
                        return redirect('auth/registrasi');
                    }
                }
            }
        }
    }

    public function verify_proses($id, $kode)
    {
        $akun = $this->akun->byID($id);

        if (verify_sha256_hash(generate_sha256_hash($akun->email), $kode)) {
            $data = [
                'status' => 'aktif',
                'verify' => 1,
            ];

            $this->akun->update($akun->email, $data);

            $this->__verifikasi($akun->email);
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Akun gagal terverifikasi!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            return redirect('auth');
        }
    }

    public function cekStatus($id)
    {
        $akun = $this->akun->byID($id);

        echo json_encode($akun);
    }

    private function __verifikasi($email)
    {
        $akun = $this->akun->byEmail($email);

        $data = [
            'akun' => $akun,
        ];

        $this->load->view('auth/verifikasi', $data);
    }

    private function __logout()
    {
        $this->session->sess_destroy();

        return redirect('auth');
    }
}
