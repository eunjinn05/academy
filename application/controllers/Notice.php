<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

	public function index()
	{
		$this->load->library('pagination');
        $this->load->model('notice_model');

		$config['base_url'] = 'http://127.0.0.1:81/index.php/';
		$config['total_rows'] = $this->notice_model->notice_board_count(); 
		$config['per_page'] = 10;

		$this->pagination->initialize($config);

        $class_data['class_name'] = $this->router->fetch_class();
        $class_data['list_data'] = $this->notice_model->notice_list_exec();

		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/list');
        $this->load->view('layout/footer', $class_data);
	}
    
	public function write($idx = null)
	{
		if ($idx != null) {
			$this->load->model('notice_model');
			$class_data['write_data'] = $this->notice_model->notice_data_exec($idx);
		}
        $class_data['class_name'] = $this->router->fetch_class();
		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/write');
        $this->load->view('layout/footer', $class_data);
	}

	public function notice_write_exec() {
        $this->load->model('notice_model');
        $this->notice_model->notice_write_exec();
	}
	
	public function notice_upload_exec() {
        $this->load->model('notice_model');
        $this->notice_model->notice_upload_exec();
	}
}
