<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Login extends CI_Controller {

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
    public function __construct() {
        parent::__construct();
        $this->load->database('db2');
	
        $this->load->model('Doffdata_Model'); // Load the model
    } 


     public function index()
	{
        $this->load->library('form_validation');        
		$this->load->model('Winding_doff_Model');
        $this->load->model('Admin_model');
        $this->load->database('db2');
        $sql='select comp_id mechine_id,company_name mechine_name from company_master
        order by company_name';
        $this->load->database(); // the TRUE paramater tells CI that you'd like to return the database object.
        $records = $this->db->query($sql)->result_array();
        $data['wndmcdata']=$records;
        $data_to_pass['data'] = $data;
        $this->load->view('admin/Login',$data_to_pass);
       
 	}
     public function authenticate() {
      
        
        $this->load->model('Admin_model');
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $compid=$this->input->post('compsel'); 
        var_dump($_POST);
        $cm='compny '.$compid;
        print_r ($cm);
        print_r ($compid);
        if ($compid==0) {
            $this->session->set_flashdata('msg','Incorrect company Data, Select Company');
            redirect(base_url().'admin/login');
}
        if ($this->form_validation->run()== true) {
                echo 'sucess';
                $username=$this->input->post('username');
                echo $username;
                $admin= $this->Admin_model->getByUsername($username);
                print_r  ($admin);
                if (!empty($admin)) {
                    $password=$this->input->post('password');
                      
                    print_r ($compid); 
                    if (password_verify($password,$admin['password']) ==true)   {
                        $adminArray['admin_id']=$admin['userID'];
                        $adminArray['username']=$admin['username'];
                        $this->session->set_userdata('admin',$adminArray)    ;
                        $company_id=$compid;
//                        $company_id=2;
                        print_r ($company_id);
                        $this->session->set_userdata('company_id', $company_id);
                        $this->load->database(); // the TRUE paramater tells CI that you'd like to return the database object.
                        $cmpname='';
                        $sql="select * from company_master where comp_id=".$compid;
                        $query1=$this->db->query($sql);
                        $row1 = $query1->row();
                        $cmpname=$row1->company_name;
                        
                        $this->session->set_userdata('company_name', $cmpname);
                        $this->session->set_userdata('username', $username);
                        redirect(base_url().'admin/home');
                        
                                
                    } 


                } else {    
                        $this->session->set_flashdata('msg','Incorrect Data');
                        redirect(base_url().'admin/login');
                }
            //success
         } else {
                echo 'error';
                $this->load->view('admin/login');
                    //error


         }

        }
    public function logout() {
                
                $this->session->unset_userdata('admin');
                redirect(base_url().'admin/login');
    }        

}
