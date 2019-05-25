<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('Usuarios_model');
	}

	public function login()
	{
        if ($this->session->userdata('login')) {
            redirect(base_url().'principal');
        }
		$this->load->view('auth/login');
	}

	public function validar(){
		$email = $this->input->post("email");
        $pass  = $this->input->post("password");
        $res = $this->Usuarios_model->logear($email, sha1($pass));
        if ($res) {
            $data = array(
                'id_user' => $res->id,
                'user'    => $res->nombres,
                'login'   => true,
                'cargo' => $res->cargo_id,
            );
            $this->session->set_userdata($data);
            redirect(base_url() . "principal");
        } else {
            $this->session->set_flashdata("error","<span><strong>Lo sentimos,</strong> el email y contraseña ingresados no coinciden con nuestros registros</span>");
            redirect(base_url());
        }
	}

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
