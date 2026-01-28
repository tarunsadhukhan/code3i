<?php
class Students extends CI_Controller {
    public function __construct() {
        parent::__construct();
          $this->load->model('Student_model');
    }

    public function index() {
           $this->load->model('student_model');
               $student_list = $this->student_model->student_list();
		$this->load->view('admin/students',['student_list'=>$student_list]);
    }

    public function get_student_data()
{
    $id = $this->input->get('id');
    $get_student = $this->Student_model->get_student_data_model($id);
    echo json_encode($get_student); 
    exit();
}

}
?>
