<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
        $class_data['class_name'] = "main";
		$this->load->view("layout/head", $class_data);
		$this->load->view('main');
        $this->load->view('layout/footer', $class_data);
	}
}
