<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	

class Category extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */


	  public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->library('form_validation');   
		$this->load->model('Category_model');
        $categories=$this->Category_model->getCategories();
		$data['categories']=$categories;
		
		$this->load->view('admin/category/pfesi');
		
	}
    public function create()
	{
		//$this->load->view('welcome_message');

				$config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

			echo 	$this->input->post('name');
//		$this->load->model('Category_model');
//		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
//		$this->form_validation->set_rules('name','Name','trim|required');
//		if ($this->form_validation->run()== true) {

			$formArray['name']=$this->input->post('name');
			$formArray['status']=$this->input->post('status');
			$formArray['created_by']=date('Y-m-d H:i:s');	

//			$this->Category_model->create($formArray);
//			$this->session->set_flashdata('success', 'Category Added Successfully');
//			redirect(base_url('admin/category'));


			//echo 'sucess';
		} else {
			echo 'error';
			$this->load->view('admin/category/create');
		}		
       
	}
    public function edit()
	{
		//$this->load->view('welcome_message');
	
        $this->load->view('admin/category/edit');
	}
    public function delete()
	{
		//$this->load->view('welcome_message');
	
        $this->load->view('admin/category/delete');
	}


}
