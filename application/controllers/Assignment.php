<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends CI_Controller {

	public function calendar()
	{
        $class_data['class_name'] = $this->router->fetch_class();

        $this->load->view("layout/head", $class_data);
		$this->load->view('assignment/calendar');
        $this->load->view('layout/footer', $class_data);
	}

	public function write()
	{
        $class_data['class_name'] = $this->router->fetch_class();

        $this->load->view("layout/head", $class_data);
		$this->load->view('assignment/write');
        $this->load->view('layout/footer', $class_data);
	}

}
