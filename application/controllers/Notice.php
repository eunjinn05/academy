<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

	public function list($page = 1)
	{
		$this->load->library('pagination');
        $this->load->model('notice_model');

		$config['base_url'] = '/index.php/notice/list';
		$config['total_rows'] = $this->notice_model->notice_board_count();
		$config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
		$config['num_links'] = 5;

		// 디자인 커스터마이징 설정
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link'); // 링크 태그에 클래스 추가

        $this->pagination->initialize($config);

        $limit = $config['per_page'];
        $page_number = $this->uri->segment($config['uri_segment'], 1);
        $start_index = ($page_number - 1) * $limit;

		$this->pagination->initialize($config);

        $class_data['class_name'] = $this->router->fetch_class();
        $class_data['list_data'] = $this->notice_model->notice_list_exec($start_index, $limit);
		$class_data['total_rows'] = $start_index;

		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/list');
        $this->load->view('layout/footer', $class_data);
	}
    
	public function write($idx = null)
	{
		
        if (!$_SESSION['admin']) {
            echo "<script>alert('잘못된 경로입니다.'); history.back(); </script>";
        }

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
        $this->load->model('common_model');
        $this->common_model->upload_exec();
	}
	
	public function notice_delete_exec() {
        $this->load->model('notice_model');
        $this->notice_model->notice_delete_exec();
	}
	
	public function view($idx = null)
	{
        $this->load->model('notice_model');

        $class_data['data'] = $this->notice_model->notice_data_exec($idx);

        $class_data['class_name'] = $this->router->fetch_class();
		$this->load->view("layout/head", $class_data);
		$this->load->view('notice/view');
        $this->load->view('layout/footer', $class_data);
	}
}
