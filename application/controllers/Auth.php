<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        // $this->load->library('session');
        $this->load->model('userappsmodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('helper_model','helpermodel');
        // if(get_cookie('bantuMasukMomois')=='YES'){
        //     $this->_loginwithcookie(get_cookie('usernameMasukMomois'),get_cookie('passwordMasukMomois'));
        // }
    }

    public function index()
    {
        $data['title'] = 'Login Pengguna Aplikasi PT. Indoneptune Net';
        if(get_cookie('bantuMasukMomois')=='YES'){
            // $this->_loginwithcookie(get_cookie('usernameMasukMomois'),get_cookie('passwordMasukMomois'));
            $data['usercok'] = get_cookie('usernameMasukMomois');
            $data['passcok'] = get_cookie('passwordMasukMomois');
        }else{
            $data['usercok'] = null;
            $data['passcok'] = null;
        }
        $this->load->view('layouts/auth_header', $data);
        $this->load->view('auth/login',$data);
        $this->load->view('layouts/auth_footer');
    }

    public function cekAuth()
    {
        $this->_login();
    }

    private function _loginwithcookie($user='',$pass=''){
         $htmlsalahpassword = '<div class="alert alert-important alert-danger alert-dismissible font-kecil" role="alert">
                                        <div class="d-flex">
                                        <div>
                                            <svg class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                        </div>
                                        <div>
                                            Password salah atau User tidak aktif !
                                        </div>
                                        </div>
                                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                    </div>';
        $htmltidakditemukan = '<div class="alert alert-important alert-danger alert-dismissible font-kecil" role="alert">
                                    <div class="d-flex">
                                    <div>
                                        <svg class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                    </div>
                                    <div>
                                        Pengguna tidak ditemukan, Sign Up terlebih  dahulu !
                                    </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>';
        $username = $user;
        $password = $pass;
        // $user = $this->db->get_where('user', ['username' => $username])->row_array();
        $user = $this->userappsmodel->getdatabyuser($username)->row_array();
        if ($user) {
            if (encrypto($password) == $user['password'] && $user['aktif'] == 1) {
                $user_data = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'jabatan' => $user['jabatan'],
                    'master' => $user['master'],
                    'manajemen' => $user['manajemen'],
                    'transaksi' => $user['transaksi'],
                    'other' => $user['other'],
                    'hakdepartemen' => $user['hakdepartemen'],
                    'level_user' => $user['idlevel'],
                    'dept_user' => $user['id_dept'],
                    'ttd' => $user['ttd'],
                    'cekpo' => $user['cekpo'],
                    'cekadj' => $user['cekadj'],
                    'viewharga' => $user['view_harga'],
                    'getinifn' => true
                ];
                $this->session->set_userdata($user_data);

                $this->session->set_userdata('arrdep',arrdep($user['hakdepartemen']));
                $this->session->set_userdata('hak_ttd_pb',arrdep($user['cekpb']));
                $this->session->set_userdata('bl',date('m'));
                $this->session->set_userdata('th',date('Y'));
                $this->session->set_userdata('datatokenbeacukai',$this->helpermodel->getbctoken());

                $this->helpermodel->isilog('LOGIN Aplikasi momois DG COOKIE');

                $url = base_url('Main');
                redirect($url);
            } else {
                $this->session->set_flashdata('message', $htmlsalahpassword);
                $url = base_url('Auth');
                redirect($url);
            }
        } else {
            $this->session->set_flashdata('message', $htmltidakditemukan);
            $url = base_url('Auth');
            redirect($url);
        }
    }

    private function _login()
    {
        $htmlsalahpassword = '<div class="alert alert-important alert-danger alert-dismissible font-kecil" role="alert">
                                        <div class="d-flex">
                                        <div>
                                            <svg class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                        </div>
                                        <div>
                                            Password salah atau User tidak aktif !
                                        </div>
                                        </div>
                                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                    </div>';
        $htmltidakditemukan = '<div class="alert alert-important alert-danger alert-dismissible font-kecil" role="alert">
                                    <div class="d-flex">
                                    <div>
                                        <svg class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                    </div>
                                    <div>
                                        Pengguna tidak ditemukan, Sign Up terlebih  dahulu !
                                    </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>';
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        // $user = $this->db->get_where('user', ['username' => $username])->row_array();
        $user = $this->userappsmodel->getdatabyuser($username)->row_array();
        if ($user) {
            if (encrypto($password) == $user['password'] && $user['aktif'] == 1) {
                $user_data = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'jabatan' => $user['jabatan'],
                    'master' => $user['master'],
                    'manajemen' => $user['manajemen'],
                    'transaksi' => $user['transaksi'],
                    'other' => $user['other'],
                    'hakdepartemen' => $user['hakdepartemen'],
                    'level_user' => $user['idlevel'],
                    'dept_user' => $user['id_dept'],
                    'ttd' => $user['ttd'],
                    'cekpo' => $user['cekpo'],
                    'cekadj' => $user['cekadj'],
                    'viewharga' => $user['view_harga'],
                    'getinifn' => true
                ];
                $this->session->set_userdata($user_data);

                $this->session->set_userdata('arrdep',arrdep($user['hakdepartemen']));
                $this->session->set_userdata('hak_ttd_pb',arrdep($user['cekpb']));
                $this->session->set_userdata('bl',date('m'));
                $this->session->set_userdata('th',date('Y'));
                if($this->input->post('ingatsaya')){
                    $cookie = array(
                        'name'   => "usernameMasukMomois",
                        'value'  => $username,
                        'expire' => 86400
                    );
                    $cookie2 = array(
                        'name'   => "passwordMasukMomois",
                        'value'  => $password,
                        'expire' => 86400
                    );
                    $cookie3 = array(
                        'name'   => "bantuMasukMomois",
                        'value'  => 'YES',
                        'expire' => 86400
                    );
                    set_cookie($cookie);
                    set_cookie($cookie2);
                    set_cookie($cookie3);
                }
                if($this->input->post('lupasaya')){
                    delete_cookie('bantuMasukMomois');
                    delete_cookie('usernameMasukMomois');
                    delete_cookie('passwordMasukMomois');
                }
                $this->helpermodel->isilog('LOGIN Aplikasi momois DG USERNAME PASSWORD');

                $url = base_url('Main');
                redirect($url);
            } else {
                $this->session->set_flashdata('message', $htmlsalahpassword);
                $url = base_url('Auth');
                redirect($url);
            }
        } else {
            $this->session->set_flashdata('message', $htmltidakditemukan);
            $url = base_url('Auth');
            redirect($url);
        }
    }

    public function logout()
    {
        // $this->loginmodel->islogout($this->session->userdata('idprofil'));
        // delete_cookie('bantuMasukMomois');
        // delete_cookie('usernameMasukMomois');
        // delete_cookie('passwordMasukMomois');
        $this->helpermodel->isilog('LOGOUT Aplikasi momois');
        $this->session->sess_destroy();
        $url = base_url('Auth');
        redirect($url);
    }
}
