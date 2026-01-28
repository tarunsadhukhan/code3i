<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactsModel extends CI_Model {

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
	public function getContacts()
	{
		//$this->load->view('welcome_message');
		//echo 'welcodem to alalal';
    //    $this->load->view('admin/dashboard');
          $this->load->database();
          $result=$this->db->query('select * from department_master');
          if ($result->num_rows()>0) {

                    return $result->result();
          } else {

            return false;
          }

    }
}
