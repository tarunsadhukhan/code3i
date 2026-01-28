<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	

class Loom_data_exp extends CI_Controller {

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
		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);

	// echo 'online';
	 
		$this->load->library('form_validation');
		$this->load->model('Doffdata_Model');
//        $categories=$this->Doffdata_Model->getCategories();
//		$data['categories']=$categories;
		
		$this->load->view('admin/doffdata/loom_data_report');
//		$this->load->view('admin/doffdata/doff10report');

	

		
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
		//$this->load->view('welcome_message');
	
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


	public function fetch_data() {
        $frameNo = $this->input->post('frameNo');
        $payrollstartdate = $this->input->post('payrollstartdate');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$payrollstartdate=substr($payrollstartdate,6,4).'-'.substr($payrollstartdate,3,2).'-'.substr($payrollstartdate,0,2);

        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
      /*
		$this->db->select('name');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $query1 = $this->db->get();
	*/	
		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		$query1=$this->db->query($sql);
//echo $sql."<br>";

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
		$query2=$this->db->query($sql);
//echo $sql;

/*
        $this->db->select_sum('weight');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $this->db->where('rundate', $rundate);
        $this->db->where('runshift', $runshift);
        $this->db->where('company_id', $company_id);
        $query2 = $this->db->get();
*/
			$q1=$query1->num_rows();
			$q2=$query2->num_rows();
//			echo 'result='.$q1.'-'.$q2;

$trlno='';
$trlwt=0;
$dfno=0;
$twt=0;


if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlno=$row1->trollyno;
	$trlwt=$row1->name+$bwt;	
}
if ( $query2->num_rows()>0 ) {
	$row2 = $query2->row();
	$dfno=$row2->noofdoff+1;
	$twt=$row2->tnetwt;	
}

$response = array(
	'success' => true,
	'trollyNo' => $trlno,
	'trollyWt' => $trlwt,
	'doffNo' => $dfno,
	'tnetWt' => $twt,
	'mcno' => $frm	

);


        echo json_encode($response);
    }


	public function fetch_qc_data() {
        $frameNo = $this->input->post('frameNo');
        $doffqcdate = $this->input->post('doffqcdate');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$doffqcdate=substr($doffqcdate,6,4).'-'.substr($doffqcdate,3,2).'-'.substr($doffqcdate,0,2);

        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
      /*
		$this->db->select('name');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $query1 = $this->db->get();
	*/	
		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		$query1=$this->db->query($sql);
//echo $sql."<br>";

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
		$query2=$this->db->query($sql);
//echo $sql;

/*
        $this->db->select_sum('weight');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $this->db->where('rundate', $rundate);
        $this->db->where('runshift', $runshift);
        $this->db->where('company_id', $company_id);
        $query2 = $this->db->get();
*/
			$q1=$query1->num_rows();
			$q2=$query2->num_rows();
//			echo 'result='.$q1.'-'.$q2;

$trlno='';
$trlwt=0;
$dfno=0;
$twt=0;


if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlno=$row1->trollyno;
	$trlwt=$row1->name+$bwt;	
}
if ( $query2->num_rows()>0 ) {
	$row2 = $query2->row();
	$dfno=$row2->noofdoff+1;
	$twt=$row2->tnetwt;	
}

$response = array(
	'success' => true,
	'trollyNo' => $trlno,
	'trollyWt' => $trlwt,
	'doffNo' => $dfno,
	'tnetWt' => $twt,
	'mcno' => $frm	

);


        echo json_encode($response);
    }



	public function trolly_data() {
        $trollyNo = $this->input->post('trollyNo');
        $companyId = $this->input->post('companyId');
		$frameNo = $this->input->post('frameNo');
		

		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

 
        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
 		$sql="select * from trollymst where company_id =$companyId and trollyno=$trollyNo and process_type=2";
		$query1=$this->db->query($sql);
 
 
 			$q1=$query1->num_rows();
 
$trlwt=0;
 

if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlwt=$row1->trolly_weight+$row1->basket_weight+$bwt;	
//echo $row1->trolly_weight.'+'.$row1->basket_weight.'+'.$bwt.'='.$trlwt;
}
 

$response = array(
	'success' => true,
	
	'trollyWt' => $trlwt
	 	

);


        echo json_encode($response);
    }





	public function get_name() {
		$this->load->model('Doffdata_Model');
        $frameNo = $this->input->post('frameNo');
	//	echo 'frameno'.$frameNo;

        // Perform necessary database operations to retrieve the name based on the empCode
        // Replace the following code with your own logic
        $name = $this->Doffdata_Model->get_name_by_empCode($frameNo);
		
        if ($name) {
            $response = array(
                'success' => true,
                'name' => $name
            );
        } else {
            $response = array(
                'success' => false
            );
        }

        echo json_encode($response);
    }

	public function save_data() {
        $frameNo = $this->input->post('frameNo');
        $payrollstartdate = $this->input->post('payrollstartdate');
        $rec_time =  date('Y-m-d H:i:s');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$payrollstartdate=substr($payrollstartdate,6,4).'-'.substr($payrollstartdate,3,2).'-'.substr($payrollstartdate,0,2);
		$trollyNo = $this->input->post('trollyNo');
		$tareWt = $this->input->post('tareWt');
		$grossWt = $this->input->post('grossWt');
		$netWt = $this->input->post('netWt');
      	$active=1;
		$entryMode='M';


		 
 	$data = array(
		'company_id' => $companyId,
		'doffdate' => $payrollstartdate,
		'entrydate' => $rec_time,
		'entry_mode' => $entryMode,
		'frameno' => $frameNo,
		'grosswt' => $grossWt,
		'is_active' => $active,
		'netwt' => $netWt,
		'spell' => $shiftName,
		'tarewt' => $tareWt,		
		'trollyno' => $trollyNo,
		'entrytime' => $rec_time

		// Exclude 'id' and 'updated_by' fields
	);
	$this->db->insert('dofftable', $data);


  $response = array(
	'success' => true,
	'frameNo' => $frameNo,
	'savedata'=> 'saved'
);

        echo json_encode($response);

    }


	public function get_records() {
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
		$compid = $this->input->post('companyId');
		$frameNo = $this->input->post('frameNo');
		
   // echo 'frame--'.$frameNo;
		$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		

        // Get the records for the specified date and shift
    //    $records = $this->Doffdata_Model->get_records($date, $shift,$compid);
		$sql="select auto_id,DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate,spell,frameno,trollyno,grosswt,tarewt,netwt from dofftable where doffdate='$date' and 
		spell='$shift' and company_id=$compid and is_active=1 order by auto_id desc";
		
		$sql = "SELECT auto_id, DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate, spell, frameno, trollyno, grosswt, tarewt, netwt ,entrytime
            FROM dofftable 
            WHERE doffdate = ? AND spell = ? AND company_id = ? "; 
			if (strlen($frameNo)>0) {
				$sql=$sql."and frameno = $frameNo ";
			}
		$sql=$sql." 
			AND is_active = 1 
            ORDER BY auto_id DESC";
    $query = $this->db->query($sql, array($date, $shift, $compid));
    $records = $query->result();
		
	//	echo $sql;
	//	$records=$this->db->query($sql);
	//	echo $sql;
		// Prepare the response
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->auto_id,
                $record->doffdate,
                $record->spell,
                $record->frameno,
                $record->trollyno,
                $record->grosswt,
                $record->tarewt,
                $record->netwt,
                $record->entrytime
                
            ];
        }

        // Return the response
        echo json_encode(['data' => $data]);
    }

}
 