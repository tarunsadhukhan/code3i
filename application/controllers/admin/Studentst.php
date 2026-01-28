<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller 
{
	public function index()
	{
               $this->load->model('student_model');
               $student_list = $this->student_model->student_list();
		$this->load->view('students',['student_list'=>$student_list]);
	}

	public function get_student_data()
	{
		$id = $this->input->get('id');
		$get_student = $this->student_model->get_student_data_model($id);
		echo json_encode($get_student); 
		exit();
	}

}

?>