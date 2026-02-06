<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $class_data['class_name'] = $this->router->fetch_class();

        $this->load->view("layout/head", $class_data);
		$this->load->view('login/main');
        $this->load->view('layout/footer', $class_data);
	}

    public function login_exec() {
        $this->load->model('login_model');
        $this->login_model->login_exec();
    }
}
