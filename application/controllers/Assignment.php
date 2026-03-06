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

	public function write($assignment_date = null)
	{
        $class_data['class_name'] = $this->router->fetch_class();
		$class_data['assignment_date'] = $assignment_date;
		
		if ($assignment_date) {
	        $this->load->model('assignment_model');
	        $class_data['data'] = $this->assignment_model->assignment_data_exec($assignment_date, 'word', 'write');
		}

        $this->load->view("layout/head", $class_data);
		$this->load->view('assignment/write');
        $this->load->view('layout/footer', $class_data);
	}

	public function assignment_upload_exec() {
        $this->load->model('common_model');
        $this->common_model->upload_exec();
	}

	public function assignment_write_exec()
	{
        $this->load->model('assignment_model');
        $this->assignment_model->assignment_write_exec();
	}

	public function view($assignment_date = null, $category = "")
	{
        $this->load->model('assignment_model');

        $class_data['data'] = $this->assignment_model->assignment_data_exec($assignment_date, $category);
		$class_data['assignment_date'] = $assignment_date;
		$class_data['category'] = $category;

        $class_data['class_name'] = $this->router->fetch_class();
		$this->load->view("layout/head", $class_data);
		$this->load->view('assignment/view');
        $this->load->view('layout/footer', $class_data);
	}

	public function assignment_delete_exec()
	{
        $this->load->model('assignment_model');
        $this->assignment_model->assignment_delete_exec();
	}


}
