<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Issue_updation extends CI_Controller {

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
        $this->load->model('Doffdata_Model'); // Load the model
    } 

	  public function index()
	{

		$company_id = $this->session->userdata('company_id');

			if (strlen($company_id)==0) { 
				redirect('admin/login/logout');
			}


		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
		$this->load->model('Doffdata_Model');
//        $categories=$this->Doffdata_Model->getCategories();
//		$data['categories']=$categories;
		
    //    $qualitydata=$this->Doffdata_Model->getspgQualitydata();
    //    $dataq['qualitydata']=$qualitydata;

    //    $data_to_pass['data'] = $data;
    //    $data_to_pass['datas'] = $datas;
     //  $data_to_pass['dataq'] = $dataq;


//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
//$this->load->view('admin/reports/Winding_data_reports', $data_to_pass);	

		$this->load->view('admin/category/Issue_updation');
		
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


		$this->load->model('Category_model');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
		$this->form_validation->set_rules('name','Name','trim|required');
		if ($this->form_validation->run()== true) {

			$formArray['name']=$this->input->post('name');
			$formArray['status']=$this->input->post('status');
			$formArray['created_by']=date('Y-m-d H:i:s');	

			$this->Category_model->create($formArray);
			$this->session->set_flashdata('success', 'Category Added Successfully');
			redirect(base_url('admin/category'));


			//echo 'sucess';
		} else {
			echo 'error';
			$this->load->view('admin/category/create');
		}		
       
	}
    
	public function frame_qc_entry()
	{
		
        $this->load->view('admin/doffdata/frame_qc_entry');


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


 	public function issue_data() {
        $itemcode = $this->input->post('itemcode');
        $isspassDate = $this->input->post('isspassDate');
        $companyId = $this->input->post('companyId');
		$issueno= $this->input->post('issueno');
		$isspassDate=substr($isspassDate,6,4).'-'.substr($isspassDate,3,2).'-'.substr($isspassDate,0,2);

 		$frm='';
		$sql="select * from scm_issue_hdr where concat(group_code,item_code)='".$itemcode."' and company_id=".$companyId. 
        " and issue_date='".$isspassDate."' and is_active=1 and hdr_id=".$issueno;	
//echo $sql;
        $bwt=0;
		$isn=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			$row1 = $query1->row();
			$frm=$row1->issue_qty;
			$bwt=$row1->is_active;
			$isn=$row1->issue_no;
 		}
 
$response = array(
	'success' => true,
	'issqty' => $frm,
	'issact' => $bwt,
	'issno' => $isn,
 );


        echo json_encode($response);
    }

	public function save_data() {
            $isspassDate = $this->input->post('isspassDate');
            $itemcode = $this->input->post('itemcode');
            $companyId = $this->input->post('companyId');
            $issueno= $this->input->post('issueno');
            $issqty = $this->input->post('issqty');
            $issact = $this->input->post('issact');
            $recid = $this->input->post('recid');
            $isspassDate=substr($isspassDate,6,4).'-'.substr($isspassDate,3,2).'-'.substr($isspassDate,0,2);
            $data = array(
                'issue_qty' => $issqty,
                'is_active' => $issact,
               );
        $this->db->where('issue_no', $recid);
        $this->db->update('scm_issue_hdr', $data);
 
		$sql="select sum(received_qty)-sum(issued_qty) clqty  from view_proc_store_receipt_transfer_issue
		where company_id=". $companyId." and tran_status=3 and concat(group_code,item_code)='".$itemcode."'";
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			$row1 = $query1->row();
			$frm=$row1->clqty;
		}	

      $response = array(
        'success' => true,
        'closqty' => $frm,
        'savedata'=> 'saved'
    );
    
    $frameNo='';        
    echo json_encode($response);
    
    
        }
    
 


}
 