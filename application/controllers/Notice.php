<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

	public function index()
	{
        $class_data['class_name'] = $this->router->fetch_class();
		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/list');
        $this->load->view('layout/footer', $class_data);
	}
    
	public function write($idx = null)
	{
        $class_data['class_name'] = $this->router->fetch_class();
		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/write');
        $this->load->view('layout/footer', $class_data);
	}
}
