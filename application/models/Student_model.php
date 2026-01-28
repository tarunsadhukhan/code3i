<?php 

class Student_model extends CI_Model{

	public function student_list()
	{
		return $this->db->select('*')
		->from('worker_master')
		->limit(20)
		->get()
		->result();
	}

	public function get_student_data_model($id)
	{
		return $this->db->select('*')
						->from('worker_master')
						->limit(20)
						->get()
						->row();
	}
}

?>